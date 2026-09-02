<?php

include_once('conectorBD.php');
include_once("adminAutos.php");

class Interior
{

  public $interior;
  public $id;


  public function __construct()
  {
    $this->id = 0;
  }
}

class Marca
{

  public $marca;
  public $imagen;
  public $autos;
  public $id;


  public function __construct()
  {
    $this->id = 0;
  }
}

class Modelo
{

  public $id;
  public $modelo;
  public $marca;


  public function __construct()
  {
    $this->id = 0;
  }
}

class Transmicion
{

  public $id;
  public $transmicion;


  public function __construct()
  {
    $this->id = 0;
  }
}

class Combustible
{

  public $id;
  public $combustible;

  public function __construct()
  {
    $this->id = 0;
  }
}

class AdministradorEditor extends conector
{
  private ?array $interioresCache = null;
  private ?array $marcasCache = null;
  private ?array $modelosCache = null;
  private ?array $transmisionesCache = null;

  private function cargarInteriores(): void
  {
    if ($this->interioresCache !== null) {
      return;
    }

    $this->interioresCache = [];
    $result = $this->ejecutar('SELECT `id`, `interior` FROM `interiores`');
    while ($row = $result->fetch_assoc()) {
      $interior = new Interior();
      $interior->id = $row['id'];
      $interior->interior = $row['interior'];
      $this->interioresCache[(int) $row['id']] = $interior;
    }
  }

  private function cargarMarcas(): void
  {
    if ($this->marcasCache !== null) {
      return;
    }

    $this->marcasCache = [];
    $result = $this->ejecutar('SELECT `id`, `marca`, `imagen` FROM `marca`');
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
      $this->marcasCache[(int) $row['id']] = $marca;
    }
  }

  private function cargarModelos(): void
  {
    if ($this->modelosCache !== null) {
      return;
    }

    $this->modelosCache = [];
    $result = $this->ejecutar('SELECT `id`, `id_marca`, `modelo` FROM `modelo`');
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['modelo'];
      $this->modelosCache[(int) $row['id']] = $modelo;
    }
  }

  private function cargarTransmisiones(): void
  {
    if ($this->transmisionesCache !== null) {
      return;
    }

    $this->transmisionesCache = [];
    $result = $this->ejecutar('SELECT `id`, `transmision` FROM `transmision`');
    while ($row = $result->fetch_assoc()) {
      $transmision = new Transmicion();
      $transmision->id = $row['id'];
      $transmision->transmicion = $row['transmision'];
      $this->transmisionesCache[(int) $row['id']] = $transmision;
    }
  }

  public function agregarInterior($interior)
  {
    $sql = "INSERT INTO `interiores` (`interior`) VALUES ('$interior');";
    $this->ejecutar($sql);
    $this->interioresCache = null;
  }

  public function agregarMarca($marca, $imagen)
  {
    $sql = "INSERT INTO `marca` (`marca`, `imagen`) VALUES ('$marca', '$imagen');";
    $this->ejecutar($sql);
    $this->marcasCache = null;
  }

  public function agregarModelo($modelo, $marca)
  {
    $sql = "INSERT INTO `modelo` (`id_marca`, `modelo`) VALUES ('$marca', '$modelo')";
    $this->ejecutar($sql);
    $this->modelosCache = null;
  }

  public function agregartransmicion($transmicion)
  {
    $sql = "INSERT INTO `transmision` (`transmision`) VALUES ('$transmicion');";
    $this->ejecutar($sql);
    $this->transmisionesCache = null;
  }

  public function eliminaInterior($id)
  {
    $sql = "DELETE FROM interiores WHERE id = $id;";
    $this->ejecutar($sql);
    $this->interioresCache = null;
  }

  public function eliminaMarca($id)
  {
    $adminAutos = new AdministradorAutos();
    if ($adminAutos->cuentaAutosPorMarca($id) == 0) {
      $sql = "DELETE FROM marca WHERE id = $id;";
      $this->ejecutar($sql);
      $this->marcasCache = null;
      return true;
    } else {
      return false;
    }
  }
  public function eliminarModelo($id)
  {
    $sql = "DELETE FROM modelo WHERE id = $id;";
    $this->ejecutar($sql);
    $this->modelosCache = null;
  }
  public function eliminaTransmicion($id)
  {
    $sql = "DELETE FROM transmision WHERE id = $id;";
    $this->ejecutar($sql);
    $this->transmisionesCache = null;
  }

  public function dameAutos($id)
  {
    $sql = "SELECT count(id) as conteo from auto WHERE id_marca = $id AND pausado = 0 and vendido = 0;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['conteo']);
    }
  }

  function dameInteriores()
  {
    $this->cargarInteriores();
    return array_values($this->interioresCache);
  }


  function dameInterior($id)
  {
    $this->cargarInteriores();
    return $this->interioresCache[(int) $id] ?? new Interior();
  }

  function existeMarcaPorNombre($nombre)
  {
    $sql = "SELECT * FROM marca WHERE marca = '$nombre';";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return true;
    }
    return false;
  }

  function dameMarcasGenerales()
  {
    $arregloMarca = array();
    $sql = "SELECT * FROM marcas ORDER BY Nombre;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['Nombre'];
      $arregloMarca[] = $marca;
    }

    return $arregloMarca;
  }

  function dameMarcas()
  {
    $arregloMarca = array();
    $sql = "SELECT m.`id`, m.`marca`, m.`imagen`, COUNT(a.`id`) AS autos
      FROM `marca` m
      LEFT JOIN `auto` a ON a.`id_marca` = m.`id` AND a.`pausado` = 0 AND a.`vendido` = 0
      GROUP BY m.`id`, m.`marca`, m.`imagen`
      ORDER BY m.`marca`;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
      $marca->autos = (int) $row['autos'];

      $arregloMarca[] = $marca;
    }

    return $arregloMarca;
  }

  function dameMarca($id)
  {
    $this->cargarMarcas();
    return $this->marcasCache[(int) $id] ?? new Marca();
  }

  function dameMarcaYModelo($marca, $modelo)
  {
    $modelos = array();
    $marcaX = $this->dameMarcaPorNombre($marca)[0]->id;
    $modeloX = $this->dameModeloPorNombre($marcaX, $modelo);
    foreach ($modeloX as $modelo) {
      $idMod = $modelo->id;
      $modelos[] =  "$marcaX - $idMod";;
    }
    return $modelos;
  }

  function dameModeloPorNombre($marca, $modelo)
  {
    $arregloModelos = [];
    $marca = (int) $marca;
    $modelo = $this->escapar((string) $modelo);
    $sql = "SELECT * FROM modelo WHERE id_marca = $marca AND modelo LIKE '%$modelo%';";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['modelo'];
      $arregloModelos[] = $modelo;
    }

    return $arregloModelos;
  }

  function dameMarcaPorNombre($nombre)
  {
    $arregloMarca = [];
    $nombre = $this->escapar((string) $nombre);
    $sql = "SELECT m.`id`, m.`marca`, m.`imagen`, COUNT(a.`id`) AS autos
      FROM `marca` m
      LEFT JOIN `auto` a ON a.`id_marca` = m.`id` AND a.`pausado` = 0 AND a.`vendido` = 0
      WHERE m.`marca` LIKE '%$nombre%'
      GROUP BY m.`id`, m.`marca`, m.`imagen`;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
      $marca->autos = (int) $row['autos'];

      $arregloMarca[] = $marca;
    }

    return $arregloMarca;
  }

  function dameModelosGenerales()
  {
    $arregloModelos = array();
    $sql = "SELECT * FROM modelos ORDER BY Nombre;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['Nombre'];
      $arregloModelos[] = $modelo;
    }

    return $arregloModelos;
  }

  function dameModelosGeneralesPorMarca($marca)
  {
    $arregloModelos = array();
    $sql = "SELECT * FROM modelos WHERE id_marca = $marca ORDER BY Nombre;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['Nombre'];
      $arregloModelos[] = $modelo;
    }

    return $arregloModelos;
  }

  function dameModeloGeneral($id)
  {
    $sql = "SELECT * FROM modelos WHERE id = $id;";
    $modelo = new Modelo();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['Nombre'];
    }

    return $modelo;
  }

  function transformaMarca($marca)
  {
    $marcaGenerica = $this->dameMarcaGeneral($marca);
    $marcaGenericaM = $marcaGenerica->marca;
    $sql = "SELECT * FROM marca WHERE marca LIKE '%$marcaGenericaM%';";
    $marca = new Marca();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
    }

    return $marca;
  }

  function dameMarcaGeneral($id)
  {

    $sql = "SELECT * FROM marcas WHERE id = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['Nombre'];
    }
    return $marca;
  }

  function dameModelos()
  {
    $arregloModelos = array();
    $sql = "SELECT modelo.*, marca.marca as mar FROM modelo 
    left join  marca
    on marca.id = modelo.id_marca
    ORDER BY modelo;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['mar'];
      $modelo->modelo = $row['modelo'];
      $arregloModelos[] = $modelo;
    }

    return $arregloModelos;
  }

  function dameModelosPorMarca($id)
  {
    $arregloModelos = array();
    $sql = "SELECT * FROM modelo WHERE id_marca = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $modelo = new Modelo();
      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['modelo'];
      $arregloModelos[] = $modelo;
    }

    return $arregloModelos;
  }
  function dameModelo($id)
  {
    $this->cargarModelos();
    return $this->modelosCache[(int) $id] ?? new Modelo();
  }
  function dameTransmiciones()
  {
    $this->cargarTransmisiones();
    return array_values($this->transmisionesCache);
  }
  function dameTransmicion($id)
  {
    $this->cargarTransmisiones();
    return $this->transmisionesCache[(int) $id] ?? new Transmicion();
  }
}
