<?php
include_once('conectorBD.php');
include_once('adminAutos.php');
class Visita
{
  public $id;
  public $fecha;
  public $ip;
  public $auto;

  public function __construct($id, $fecha, $ip, $auto)
  {
    $this->id = $id;
    $this->fecha = $fecha;
    $this->ip = $ip;
    $this->auto = $auto;
  }
}

class Mes
{
  public $mes;
  public $visitas;
  public $autoMasVisitado;
  public $autoMenosVisitado;

  public function __construct($mes, $visitas, $autoMasVisitado, $autoMenosVisitado)
  {
    $this->mes = $mes;
    $this->visitas = $visitas;
    $this->autoMasVisitado = $autoMasVisitado;
    $this->autoMenosVisitado = $autoMenosVisitado;
  }
}

class VisitasAuto
{
  public $auto;
  public $visitas;

  public function __construct($auto, $visitas)
  {
    $this->auto = $auto;
    $this->visitas = $visitas;
  }
}


class AdministradorEstadisticas extends conector
{

  public function insertaVisita($ip, $auto)
  {
    $ip = $this->escapar((string) $ip);
    $auto = (int) $auto;
    $sql = "INSERT INTO visitasAuto (ip, auto) VALUES ('$ip', '$auto')";
    $this->ejecutar($sql);
  }

  function dameVisitasPorAuto($dia)
  {
    $adminAutos = new AdministradorAutos();
    $autos = $adminAutos->dameAutosConDiasDeSuvido(3);
    if ($autos === []) {
      return [];
    }

    $dia = (int) $dia;
    $ids = implode(',', array_map(static fn(Auto $auto): int => (int) $auto->id, $autos));
    $anio = (int) date('Y');
    $sql = "SELECT auto, COUNT(*) AS visitas
      FROM visitasAuto
      WHERE auto IN ($ids) AND YEAR(fecha) = $anio AND DAY(fecha) BETWEEN " . ($dia - 7) . " AND $dia
      GROUP BY auto";
    $resultado = $this->ejecutar($sql);
    $conteos = [];
    while ($fila = $resultado->fetch_assoc()) {
      $conteos[(int) $fila['auto']] = $fila['visitas'];
    }

    $visitasPorAuto = array();
    foreach ($autos as $auto) {
      $visitasPorAuto[] = new VisitasAuto($auto->marca->marca . " " . $auto->modelo->modelo, $conteos[(int) $auto->id] ?? 0);
    }
    return $visitasPorAuto;
  }

  public function cuentaVisitasPorSemana($dia, $auto)
  {
    $sql = "SELECT COUNT(*) FROM visitasAuto WHERE auto = '$auto' AND YEAR(fecha) = " . date('Y') . "  AND DAY(fecha) between '$dia'-7 and '$dia'";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['COUNT(*)'];
  }


  public function dameVisitasAutoPorSemana($dia, $auto)
  {
    $sql = "SELECT * FROM visitasAuto WHERE auto = '$auto' AND DAY(fecha) between '$dia'-4 and '$dia'+4";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }



  public function generaAnio()
  {
    $anioActual = (int) date('Y');
    $inicio = sprintf('%04d-01-01', $anioActual);
    $fin = sprintf('%04d-01-01', $anioActual + 1);
    $sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS visitas
      FROM visitasAuto
      WHERE fecha >= '$inicio' AND fecha < '$fin'
      GROUP BY MONTH(fecha)";
    $resultado = $this->ejecutar($sql);
    $porMes = [];
    while ($fila = $resultado->fetch_assoc()) {
      $porMes[(int) $fila['mes']] = $fila['visitas'];
    }

    $anio = [];
    for ($i = 0; $i < 12; $i++) {
      $mes = $i + 1;
      $anio[$i] = new Mes($mes, $porMes[$mes] ?? 0, "", "");
    }
    return $anio;
  }

  public function dameAutoMasVisitadoPorMes($anio, $mes)
  {
  }

  public function dameEstadisticasPorMes()
  {
    $sql = "SELECT COUNT(*) AS visitas, MONTH(fecha) AS mes FROM visitasAuto GROUP BY mes";
    $resultado = $this->ejecutar($sql);
    $estadisticas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $estadisticas[] = $fila;
    }
    return $estadisticas;
  }

  public function dameVisitasEnero($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 1 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasFebrero($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 2 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasMarzo($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 3 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasAbril($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 4 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasMayo($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 5 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasJunio($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 6 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasJulio($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 7 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasAgosto($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 8 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasSeptiembre($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 9 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasOctubre($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 10 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasNoviembre($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 11 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  public function dameVisitasDiciembre($anio)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = 12 AND YEAR(fecha) = $anio";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  function cuentaVisitasMesAnio($mes, $anio)
  {
    $mes = min(12, max(1, (int) $mes));
    $anio = (int) $anio;
    $inicio = sprintf('%04d-%02d-01', $anio, $mes);
    $fin = (new DateTimeImmutable($inicio))->modify('+1 month')->format('Y-m-d');
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE fecha >= '$inicio' AND fecha < '$fin'";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }

  function dameEstadisticasPorMesAnio($mes, $anio)
  {
    $sql = "SELECT COUNT(*) AS visitas, MONTH(fecha) AS mes FROM visitasAuto WHERE MONTH(fecha) = $mes AND YEAR(fecha) = $anio GROUP BY mes";
    $resultado = $this->ejecutar($sql);
    $estadisticas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $estadisticas[] = $fila;
    }
    return $estadisticas;
  }

  function dameEstedisticasMes($mes)
  {
    $sql = "SELECT COUNT(*) AS visitas FROM visitasAuto WHERE MONTH(fecha) = $mes";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['visitas'];
  }
  public function dameEstadisticas()
  {
    $sql = "SELECT * FROM visitasAuto";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorAuto($auto)
  {
    $sql = "SELECT * FROM visitasAuto WHERE auto = '$auto'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorFecha($fecha)
  {
    $sql = "SELECT * FROM visitasAuto WHERE fecha = '$fecha'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorIp($ip)
  {
    $sql = "SELECT * FROM visitasAuto WHERE ip = '$ip'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorFechaYAuto($fecha, $auto)
  {
    $sql = "SELECT * FROM visitasAuto WHERE fecha = '$fecha' AND auto = '$auto'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorFechaIp($fecha, $ip)
  {
    $sql = "SELECT * FROM visitasAuto WHERE fecha = '$fecha' AND ip = '$ip'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }

  public function dameEstadisticasPorFechaAutoIp($fecha, $auto, $ip)
  {
    $sql = "SELECT * FROM visitasAuto WHERE fecha = '$fecha' AND auto = '$auto' AND ip = '$ip'";
    $resultado = $this->ejecutar($sql);
    $visitas = array();
    while ($fila = $resultado->fetch_assoc()) {
      $visitas[] = new Visita($fila['id'], $fila['fecha'], $fila['ip'], $fila['auto']);
    }
    return $visitas;
  }
}
