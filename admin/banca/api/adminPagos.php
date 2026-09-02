<?php
if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
    session_start();
}
include_once("conectorBD.php");


class Pago{
    //SELECT `id`, `monto`, `id_venta`, `estatus`, `fecha_pago`, `fecha_inserta` FROM `pago` WHERE 1
    public $id;
    public $monto;
    public $id_venta;
    public $estatus;
    public $fecha_pago;
    public $fecha_inserta;
    public $identificador;
    public $usuarioInserta;
    public $metodo;
    public $tipo_pago;

    public function __construct($id, $monto, $id_venta, $estatus, $fecha_pago, $fecha_inserta){
        $this->id = $id;
        $this->monto = $monto;
        $this->id_venta = $id_venta;
        $this->estatus = $estatus;
        $this->fecha_pago = $fecha_pago;
        $this->fecha_inserta = $fecha_inserta;
    }
}

class PagoEvento{
    //SELECT `id`, `id_venta`, `fecha_prospecto`, `monto_acumulado` FROM `pago_evento` WHERE 1
    public $id;
    public $id_venta;
    public $fecha_prospecto;
    public $monto_acumulado;
    public $monto_pagar;
    public $identificador;
    public $monto_interes;
    public $num_pago;

    public function __construct($id, $id_venta, $fecha_prospecto, $monto_acumulado){
        $this->id = $id;
        $this->id_venta = $id_venta;
        $this->fecha_prospecto = $fecha_prospecto;
        $this->monto_acumulado = $monto_acumulado;
    }
}



class AdministradorPagos extends conectorB {
    public function insertaPago($monto, $id_venta, $estatus, $fecha_pago, $metodo, $tipo_pago){
        $usuarioInserta = $_SESSION['sesionUsuario']['id'];
        $query = "INSERT INTO `pago`(`monto`, `id_venta`, `estatus`, `fecha_pago`,`usuario_inserta` , `metodo`, `tipo_pago`) VALUES ($monto, $id_venta, '$estatus', '$fecha_pago', '$usuarioInserta', '$metodo', '$tipo_pago')";
        $this->ejecutar($query);
        return $this->ultimoIdInsertado();
    }

    public function insertaPagoEvento($id_venta, $fecha_prospecto, $monto_acumulado, $monto_pagar, $monto_interes, $num_pago){
        $query = "INSERT INTO `pago_evento`(`id_venta`, `fecha_prospecto`, `monto_acumulado`,`monto_pagar`, `monto_interes`, `num_pago`) VALUES ($id_venta, '$fecha_prospecto', $monto_acumulado, $monto_pagar, $monto_interes, $num_pago)";
        $result = $this->ejecutar($query);
        return $result;
    }

    public function damePagosEventos($venta){
        $eventos = $this->damePagosEventosPorVentas([(int) $venta]);
        return $eventos[(int) $venta] ?? [];
    }

    public function damePagosEventosPorVentas(array $ventas): array
    {
        $ventas = array_values(array_unique(array_filter(array_map('intval', $ventas), static fn(int $id): bool => $id > 0)));
        if ($ventas === []) {
            return [];
        }

        $ids = implode(',', $ventas);
        $query = "SELECT pago_evento.*, marca.marca as marca_nombre, modelo.modelo as modelo_nombre, clientes_banca.nombre, clientes_banca.apellidos FROM `pago_evento`
        inner join venta on venta.id = pago_evento.id_venta
        inner join clientes_banca on clientes_banca.id = venta.id_cliente
        inner join autoVentas on autoVentas.id_previo = venta.id_auto
        inner join marca on marca.id = autoVentas.id_marca
        inner join modelo on modelo.id = autoVentas.id_modelo 
         WHERE pago_evento.`id_venta` IN ($ids)
         group by pago_evento.id";
        $result = $this->ejecutar($query);
        $pagos = [];
        while($row = mysqli_fetch_array($result)){
            $pago = new PagoEvento($row['id'], $row['id_venta'], $row['fecha_prospecto'], ($row['monto_acumulado']));
            $pago->monto_pagar = $row['monto_pagar'];
            $pago->identificador = $row['marca_nombre']." ".$row['modelo_nombre']." - ".$row['nombre']." ".$row['apellidos'];
            $pago->monto_interes = $row['monto_interes'];
            $pagos[(int) $row['id_venta']][] = $pago;
        }
        return $pagos;
    }

    public function damePagosEventoNoCubierto($venta, $monto){
        $query = "SELECT * FROM `pago_evento` WHERE `id_venta` = $venta and (monto_acumulado + monto_interes) > $monto";
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new PagoEvento($row['id'], $row['id_venta'], $row['fecha_prospecto'], $row['monto_acumulado']);
            $pago->monto_interes = $row['monto_interes'];
            $pago->monto_pagar = $row['monto_pagar'];
            $pago->num_pago = $row['num_pago'];

            array_push($pagos, $pago);
        }
        return $pagos;
    }
    public function damePagosEventoVencidos($venta, $monto, $fecha){
        $query = "SELECT * FROM `pago_evento` WHERE `id_venta` = $venta and (monto_acumulado + monto_interes) > $monto and fecha_prospecto < '$fecha' and se_atraso = 0";
        //echo $query;
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new PagoEvento($row['id'], $row['id_venta'], $row['fecha_prospecto'], $row['monto_acumulado']);
            $pago->monto_interes = $row['monto_interes'];
            array_push($pagos, $pago);
        }
        return $pagos;
    }

    public function marcarPagoAtrasado($id){
        $query = "UPDATE `pago_evento` SET `se_atraso`= 1 WHERE `id` = $id";
        $result = $this->ejecutar($query);
        return $result;
    }

    public function damePagoProximo($id_venta, $monto){
        $id_venta = (int) $id_venta;
        $monto = (float) $monto;
        $fecha = date("Y-m-d");
        $montoVal = $monto+1;
        $query = "SELECT * FROM `pago_evento` WHERE `id_venta` = $id_venta and fecha_prospecto > '$fecha' and monto_acumulado > $montoVal order by fecha_prospecto asc limit 1";
        //echo $query;
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        return $row ? new PagoEvento($row['id'], $row['id_venta'], $row['fecha_prospecto'], $row['monto_acumulado']) : null;
    }
    public function eliminaPago($id){
        $query = "DELETE FROM `pago` WHERE `id` = $id";
        $result = $this->ejecutar($query);
        return $result;
    }
    public function modificaPago($id, $monto, $id_venta, $estatus, $fecha_pago){
        $query = "UPDATE `pago` SET `monto`=$monto,`id_venta`=$id_venta,`estatus`='$estatus',`fecha_pago`='$fecha_pago' WHERE `id` = $id";
        $result = $this->ejecutar($query);
        return $result;
    }
    public function damePagos(){
        $query = "SELECT * FROM `pago` WHERE 1";
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new Pago($row['id'], $row['monto'], $row['id_venta'], $row['estatus'], $row['fecha_pago'], $row['fecha_inserta']);
            array_push($pagos, $pago);
        }
        return $pagos;
    }
    public function damePagosPendientes(){
        $query = "SELECT pago.*, marca.marca as marca_nombre, modelo.modelo as modelo_nombre, clientes_banca.nombre, clientes_banca.apellidos, usuario.nombre as nombre_usuario   FROM `pago`
		inner join venta on venta.id = pago.id_venta
        inner join clientes_banca on clientes_banca.id = venta.id_cliente
        inner join autoVentas on autoVentas.id_previo = venta.id_auto
        inner join marca on marca.id = autoVentas.id_marca
        inner join modelo on modelo.id = autoVentas.id_modelo 
        inner join usuario on usuario.id = pago.usuario_inserta
        WHERE pago.estatus = 'Pendiente' group by pago.id";
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new Pago($row['id'], $row['monto'], $row['id_venta'], $row['estatus'], $row['fecha_pago'], $row['fecha_inserta']);
            $pago->identificador = $row['marca_nombre']." ".$row['modelo_nombre']." - ".$row['nombre']." ".$row['apellidos'];
            $pago->usuarioInserta = $row['nombre_usuario'];
            $pago->metodo = $row['metodo'];
            $pago->tipo_pago = $row['tipo_pago'];
            array_push($pagos, $pago);
        }
        return $pagos;
    }
    public function damePagosAprobados(){
        $query = "SELECT pago.*, marca.marca as marca_nombre, modelo.modelo as modelo_nombre, clientes_banca.nombre, clientes_banca.apellidos, usuario.nombre as nombre_usuario  FROM `pago`
		inner join venta on venta.id = pago.id_venta
        inner join clientes_banca on clientes_banca.id = venta.id_cliente
        inner join autoVentas on autoVentas.id_previo = venta.id_auto
        inner join marca on marca.id = autoVentas.id_marca
        inner join modelo on modelo.id = autoVentas.id_modelo 
        inner join usuario on usuario.id = pago.usuario_inserta
        WHERE pago.estatus = 'Aprobado' group by pago.id";
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new Pago($row['id'], $row['monto'], $row['id_venta'], $row['estatus'], $row['fecha_pago'], $row['fecha_inserta']);
            $pago->identificador = $row['marca_nombre']." ".$row['modelo_nombre']." - ".$row['nombre']." ".$row['apellidos'];
            $pago->usuarioInserta = $row['nombre_usuario'];
            array_push($pagos, $pago);
        }
        return $pagos;
    }
    public function aprobarPago($id){
        $query = "UPDATE `pago` SET `estatus`='Aprobado' WHERE `id` = $id";
        $result = $this->ejecutar($query);
        //echo $query;
        return $result;
    }
    public function damePago($id){
        $query = "SELECT pago.*, marca.marca as marca_nombre, modelo.modelo as modelo_nombre, clientes_banca.nombre, clientes_banca.apellidos, usuario.nombre as nombre_usuario  FROM `pago`
		inner join venta on venta.id = pago.id_venta
        inner join clientes_banca on clientes_banca.id = venta.id_cliente
        inner join autoVentas on autoVentas.id_previo = venta.id_auto
        inner join marca on marca.id = autoVentas.id_marca
        inner join modelo on modelo.id = autoVentas.id_modelo 
        inner join usuario on usuario.id = pago.usuario_inserta
        WHERE pago.id = $id";
        $result = $this->ejecutar($query);
        $row = mysqli_fetch_array($result);
        $pago = new Pago($row['id'], $row['monto'], $row['id_venta'], $row['estatus'], $row['fecha_pago'], $row['fecha_inserta']);
        $pago->identificador = $row['marca_nombre']." ".$row['modelo_nombre']." - ".$row['nombre']." ".$row['apellidos'];
        $pago->usuarioInserta = $row['nombre_usuario'];
        return $pago;
    }
    public function damePagosVenta($id_venta){
        $query = "SELECT pago.*, usuario.nombre FROM `pago`
        inner join usuario ON usuario.id = pago.usuario_inserta
        WHERE `id_venta` = $id_venta;";
        $result = $this->ejecutar($query);
        $pagos = array();
        while($row = mysqli_fetch_array($result)){
            $pago = new Pago($row['id'], $row['monto'], $row['id_venta'], $row['estatus'], $row['fecha_pago'], $row['fecha_inserta']);
            $pago->usuarioInserta = $row['nombre'];
            $pago->metodo = $row['metodo'];
            $pago->tipo_pago = $row['tipo_pago'];
            array_push($pagos, $pago);
        }
        return $pagos;
    }
}
