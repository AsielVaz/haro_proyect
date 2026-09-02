<?php
include_once("conectorBD.php");

class EstadisticaInventario
{
    public $id;
    public $autos_cantidad;
    public $monto_cantidad;
    public $fecha;

    public function __construct($id, $autos_cantidad, $monto_cantidad, $fecha)
    {
        $this->id = $id;
        $this->autos_cantidad = $autos_cantidad;
        $this->monto_cantidad = $monto_cantidad;
        $this->fecha = $fecha;
    }
}

class EstadisticaInventA
{
    public $mes;
    public $anio;
    public $autos_cantidad;
    public $monto_cantidad;
    public $intereses;

    public function __construct($mes, $anio, $autos_cantidad, $monto_cantidad)
    {
        $this->mes = $mes;
        $this->anio = $anio;
        $this->autos_cantidad = $autos_cantidad;
        $this->monto_cantidad = $monto_cantidad;
    }
}


class AdminUtil extends conectorB
{
    public function dameEstadisticasUtil()
    {
        $query = "SELECT * FROM estadistica_inventario";
        $result = $this->ejecutar($query);
        $estadisticas = array();
        while ($row = mysqli_fetch_array($result)) {
            $estadistica = new EstadisticaInventario($row["id"], $row["autos_cantidad"], $row["monto_cantidad"], $row["fecha"]);
            array_push($estadisticas, $estadistica);
        }
        return $estadisticas;
    }

    public function dameSumaConsig(){
        $sql = "SELECT sum(precio)  as precio FROM `auto` where consig = 1;";
        $result = $this->ejecutar($sql);

        $row = mysqli_fetch_array($result);

        $restante = $row['precio'];


        

        return $restante;
    }

    public function dameConteoConsig(){
        $sql = "SELECT COUNT(*)  as precio FROM `auto` where consig = 1;";
        $result = $this->ejecutar($sql);

        $row = mysqli_fetch_array($result);

        $restante = $row['precio'];


        

        return $restante;
    }

    public function dameEstadisticasVenta(){
        $query = "SELECT
        YEAR(fecha) AS anio,
        MONTH(fecha) AS mes,
        AVG(montos_cantidad) AS monto_cantidad,
        AVG(ventas_cantidad) as ventas_cantidad,
         AVG(intereses) as intereses

      FROM
        ventas_dia
      GROUP BY
        anio, mes;";
        $result = $this->ejecutar($query);
        $estadisticas = array();
        while ($row = mysqli_fetch_array($result)) {
            $estadistica = new EstadisticaInventA($row["mes"], $row["anio"], $row["ventas_cantidad"], $row["monto_cantidad"]);
            $estadistica->intereses = $row["intereses"];
            array_push($estadisticas, $estadistica);
        }
        return $estadisticas;
    }

    public function estadisticasInvSinVender(){
        $query = "SELECT
        YEAR(fecha_subido) AS anio,
        MONTH(fecha_subido) AS mes,
        COUNT(*) AS cantidad
    FROM
        auto
    WHERE
        vendido = 0
    GROUP BY
        YEAR(fecha_subido),
        MONTH(fecha_subido);";
        $result = $this->ejecutar($query);
        $estadisticas = array();
        while ($row = mysqli_fetch_array($result)) {
            $estadistica = new EstadisticaInventA($row["mes"], $row["anio"], $row["cantidad"], 0);
            array_push($estadisticas, $estadistica);
        }
        return $estadisticas;

    }

    public function dameEstadisticaInventarioA()
    {
        $query = "SELECT
        YEAR(fecha) AS anio,
        MONTH(fecha) AS mes,
        AVG(monto_cantidad) AS monto_cantidad,
        AVG(autos_cantidad) as autos_cantidad
      FROM
        inventario_dia
      GROUP BY
        anio, mes;";
        $result = $this->ejecutar($query);
        $estadisticas = array();
        while ($row = mysqli_fetch_array($result)) {
            $estadistica = new EstadisticaInventA($row["mes"], $row["anio"], $row["autos_cantidad"], $row["monto_cantidad"]);
            array_push($estadisticas, $estadistica);
        }
        return $estadisticas;
    }
}
