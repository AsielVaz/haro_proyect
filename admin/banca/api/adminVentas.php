<?php

if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
    session_start();
}



include_once("conectorBD.php");

include_once("adminPagos.php");

class Venta
{

    //SELECT `id`, `precio_inicial`, `precio_pactado`, `id_auto`, `pago_inicial`, `fecha_inicio_pagos`, `acuerdo_pagos`, `id_cliente`, `fecha_inserta` FROM `venta` WHERE 1

    public $id;

    public $precio_inicial;

    public $precio_pactado;

    public $id_auto;

    public $pago_inicial;

    public $fecha_inicio_pagos;

    public $acuerdo_pagos;

    public $id_cliente;

    public $fecha_inserta;

    public $identificador;

    public $restante;

    public $pagos_acumulados;

    public $imagen_auto;

    public $periodo_venta;

    public $pagos_periodo;

    public $status_venta;

    public $comision;

    public $interes_acumulado;

    public $porcentaje_pactado;

    public $pagos_atrasados;

    public $color;



    public function __construct($id, $precio_inicial, $precio_pactado, $id_auto, $pago_inicial, $fecha_inicio_pagos, $acuerdo_pagos, $id_cliente, $fecha_inserta)
    {

        $this->id = $id;

        $this->precio_inicial = $precio_inicial;

        $this->precio_pactado = $precio_pactado;

        $this->id_auto = $id_auto;

        $this->pago_inicial = $pago_inicial;

        $this->fecha_inicio_pagos = $fecha_inicio_pagos;

        $this->acuerdo_pagos = $acuerdo_pagos;

        $this->id_cliente = $id_cliente;

        $this->fecha_inserta = $fecha_inserta;

        $this->color = '#5A9F19';
    }
}







class AdministradorVentas extends conectorB
{

    private function consultarVentas(string $condicion = ''): mysqli_result
    {
        $query = "SELECT venta.*, marca.marca AS marca_nombre, modelo.modelo AS modelo_nombre,
            clientes_banca.nombre, clientes_banca.apellidos,
            COALESCE(totales.total_aprobado, 0) AS total_aprobado,
            COALESCE(totales.total_abonos, 0) AS total_abonos
            FROM `venta`
            INNER JOIN clientes_banca ON clientes_banca.id = venta.id_cliente
            INNER JOIN autoVentas ON autoVentas.id_previo = venta.id_auto
            INNER JOIN marca ON marca.id = autoVentas.id_marca
            INNER JOIN modelo ON modelo.id = autoVentas.id_modelo
            LEFT JOIN (
                SELECT id_venta,
                    SUM(CASE WHEN estatus = 'Aprobado' THEN monto ELSE 0 END) AS total_aprobado,
                    SUM(CASE WHEN estatus = 'Aprobado' AND tipo_pago = 'Abono' THEN monto ELSE 0 END) AS total_abonos
                FROM pago
                GROUP BY id_venta
            ) totales ON totales.id_venta = venta.id
            $condicion
            GROUP BY venta.id";

        return $this->ejecutar($query);
    }

    private function crearVenta(array $row): Venta
    {
        $venta = new Venta($row['id'], $row['precio_inicial'], $row['precio_pactado'], $row['id_auto'], $row['pago_inicial'], $row['fecha_inicio_pagos'], $row['acuerdo_pagos'], $row['id_cliente'], $row['fecha_inserta']);
        $venta->identificador = $row['marca_nombre'] . " " . $row['modelo_nombre'] . " - " . $row['nombre'] . " " . $row['apellidos'];
        $venta->restante = (float) $row['precio_pactado'] - (float) $row['total_aprobado'] + (float) $row['comision'];
        $venta->comision = $row['comision'];
        $venta->pagos_acumulados = (float) $row['total_abonos'];
        $venta->interes_acumulado = $row['interes_acumulado'];
        $venta->porcentaje_pactado = $row['porcentaje_pactado'];
        return $venta;
    }



    public function dameRestante($id)
    {
        $id = (int) $id;
        $query = "SELECT v.precio_pactado, v.comision, COALESCE(SUM(p.monto), 0) AS total
            FROM venta v
            LEFT JOIN pago p ON p.id_venta = v.id AND p.estatus = 'Aprobado'
            WHERE v.id = $id
            GROUP BY v.id, v.precio_pactado, v.comision";
        $row = $this->ejecutar($query)->fetch_assoc();
        return $row ? (float) $row['precio_pactado'] - (float) $row['total'] + (float) $row['comision'] : 0.0;
    }

    public function damePagosAcumulados($id)
    {

        $query = "SELECT SUM(`monto`) as total FROM `pago` WHERE `id_venta` = $id and `estatus` = 'Aprobado' and `tipo_pago` = 'Abono'";

        $this->ejecutar($query);
        $id = $this->ultimoIdInsertado();

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return floatval($total);
    }

    public function insertaVenta($precio_inicial, $precio_pactado, $id_auto, $pago_inicial, $fecha_inicio_pagos, $acuerdo_pagos, $id_cliente, $periodo_venta, $comision, $porcentaje_pactado)
    {

        $usuarioInserta = $_SESSION['sesionUsuario']['id'];

        $query = "INSERT INTO `venta`(`precio_inicial`, `precio_pactado`, `id_auto`, `pago_inicial`, `fecha_inicio_pagos`, `acuerdo_pagos`, `id_cliente`, `periodo_venta`, `usuario_inserta`, `estatus_venta`, `comision`, `porcentaje_pactado`) VALUES ($precio_inicial, $precio_pactado, $id_auto, $pago_inicial, '$fecha_inicio_pagos', '$acuerdo_pagos', $id_cliente, $periodo_venta, $usuarioInserta, 'Pendiente', $comision, $porcentaje_pactado)";

        //echo $query;

        $result = $this->ejecutar($query);


        //marcar auto como vendido 

        $query = "UPDATE `auto` SET `vendido`= 1 WHERE `id` = $id_auto";

        $this->ejecutar($query);

        return $id;
    }

    public function cambiarIntereses($id, $monto)
    {

        $query = "UPDATE `venta` SET `interes_acumulado`=$monto WHERE `id` = $id";

        $result = $this->ejecutar($query);
    }

    public function dameVentas()
    {
        $result = $this->consultarVentas();
        $ventas = array();
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $this->crearVenta($row);
        }
        return $ventas;
    }



    public function dameVentasSinCompletar()
    {
        $adminPagos = new AdministradorPagos();
        $result = $this->consultarVentas();
        $ventas = array();
        while ($row = $result->fetch_assoc()) {
            $venta = $this->crearVenta($row);
            if ($venta->restante > 0) {
                $ventas[] = $venta;
            }
        }
        $eventos = $adminPagos->damePagosEventosPorVentas(array_map(static fn(Venta $venta): int => (int) $venta->id, $ventas));
        foreach ($ventas as $venta) {
            $venta->pagos_acumulados = $eventos[(int) $venta->id] ?? [];
        }
        return $ventas;
    }



    public function dameVentasPendientes()
    {
        $adminPagos = new AdministradorPagos();
        $result = $this->consultarVentas("WHERE venta.estatus_venta = 'Pendiente'");
        $ventas = array();
        while ($row = $result->fetch_assoc()) {
            $venta = $this->crearVenta($row);
            if ($venta->restante > 0) {
                $ventas[] = $venta;
            }
        }
        $eventos = $adminPagos->damePagosEventosPorVentas(array_map(static fn(Venta $venta): int => (int) $venta->id, $ventas));
        foreach ($ventas as $venta) {
            $venta->pagos_acumulados = $eventos[(int) $venta->id] ?? [];
        }
        return $ventas;
    }



    public function dameVentasConcluidas()
    {
        $result = $this->consultarVentas();
        $ventas = array();
        while ($row = $result->fetch_assoc()) {
            $venta = $this->crearVenta($row);
            if ($venta->restante <= 0) {
                $ventas[] = $venta;
            }
        }
        return $ventas;
    }



    public function dameVentasCliente($cliente)
    {

        $query = "SELECT `id`, `precio_inicial`, `precio_pactado`, `id_auto`, `pago_inicial`, `fecha_inicio_pagos`, `acuerdo_pagos`, `id_cliente`, `fecha_inserta` FROM `venta` WHERE `id_cliente` = $cliente group by venta.id";

        $result = $this->ejecutar($query);

        $ventas = array();

        while ($row = mysqli_fetch_array($result)) {

            $venta = new Venta($row['id'], $row['precio_inicial'], $row['precio_pactado'], $row['id_auto'], $row['pago_inicial'], $row['fecha_inicio_pagos'], $row['acuerdo_pagos'], $row['id_cliente'], $row['fecha_inserta']);

            array_push($ventas, $venta);
        }

        return $ventas;
    }

    public function dameVenta($id)
    {
        $id = (int) $id;
        $query = "SELECT venta.*, marca.marca as marca_nombre, modelo.modelo as modelo_nombre,
        clientes_banca.nombre, clientes_banca.apellidos, autoVentas.imagen,
        COALESCE(totales.total_aprobado, 0) AS total_aprobado,
        COALESCE(totales.total_abonos, 0) AS total_abonos FROM `venta`

        inner join clientes_banca on clientes_banca.id = venta.id_cliente

        inner join autoVentas on autoVentas.id_previo = venta.id_auto

        inner join marca on marca.id = autoVentas.id_marca

        inner join modelo on modelo.id = autoVentas.id_modelo

        LEFT JOIN (
            SELECT id_venta,
                SUM(CASE WHEN estatus = 'Aprobado' THEN monto ELSE 0 END) AS total_aprobado,
                SUM(CASE WHEN estatus = 'Aprobado' AND tipo_pago = 'Abono' THEN monto ELSE 0 END) AS total_abonos
            FROM pago GROUP BY id_venta
        ) totales ON totales.id_venta = venta.id

        WHERE venta.id = $id";

        $result = $this->ejecutar($query);

        $venta = null;

        while ($row = mysqli_fetch_array($result)) {

            $venta = new Venta($row['id'], $row['precio_inicial'], $row['precio_pactado'], $row['id_auto'], $row['pago_inicial'], $row['fecha_inicio_pagos'], $row['acuerdo_pagos'], $row['id_cliente'], $row['fecha_inserta']);

            $venta->identificador = $row['marca_nombre'] . " " . $row['modelo_nombre'] . " - " . $row['nombre'] . " " . $row['apellidos'];

            $venta->imagen_auto = $row['imagen'];

            $venta->pagos_acumulados = (float) $row['total_abonos'];

            $venta->restante = (float) $row['precio_pactado'] - (float) $row['total_aprobado'] + (float) $row['comision'];

            $venta->interes_acumulado = $row['interes_acumulado'];

            $venta->comision = $row['comision'];
        }

        return $venta;
    }



    public function sumaVentas()
    {

        $query = "SELECT SUM(`precio_pactado`) as total FROM `venta`";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function sumaVentasDia()
    {

        $query = "SELECT SUM(`precio_pactado`) as total FROM `venta` where fecha_inserta ='" . date("Y-m-d") . "'";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function sumaIntereses()
    {

        $query = "SELECT SUM(`interes_acumulado` + `comision`) as total FROM `venta`";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function sumaInteresesDia()
    {

        $query = "SELECT SUM(`interes_acumulado` + `comision`) as total FROM `venta` where fecha_inserta ='" . date("Y-m-d")  . "'";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function cuentaVentas()
    {

        $query = "SELECT COUNT(`id`) as total FROM `venta`";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function cuentaVentasDia()
    {

        $query = "SELECT COUNT(`id`) as total FROM `venta` where fecha_inserta ='" . date("Y-m-d") . "'";

        $result = $this->ejecutar($query);

        $row = mysqli_fetch_array($result);

        $total = $row['total'];

        return $total;
    }

    public function sumaMontosAutosV()
    {

        $sql = "SELECT SUM(precio) as suma FROM `auto` where consig = 0;";

        $result = $this->ejecutar($sql);

        $row = $result->fetch_assoc();

        return $row['suma'];
    }



    public function cuentaAutosValidosV()
    {

        $sql = "SELECT count(*) as cuenta FROM `auto` where consig = 0;";

        $result = $this->ejecutar($sql);

        $row = $result->fetch_assoc();

        return $row['cuenta'];
    }
}
