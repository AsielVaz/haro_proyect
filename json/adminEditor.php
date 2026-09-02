<?php

include_once('conectorBD.php');

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

  public function agregarInterior($interior)
  {
    $sql = "INSERT INTO `interiores` (`interior`) VALUES ('$interior');";
    $this->ejecutar($sql);
  }

  public function agregarMarca($marca, $imagen)
  {
    $sql = "INSERT INTO `marca` (`marca`, `imagen`) VALUES ('$marca', '$imagen');";
    $this->ejecutar($sql);
  }

  public function agregarModelo($modelo, $marca)
  {
    $sql = "INSERT INTO `modelo` (`id_marca`, `modelo`) VALUES ('$marca', '$modelo')";
    $this->ejecutar($sql);
  }

  public function agregartransmicion($transmicion)
  {
    $sql = "INSERT INTO `transmision` (`transmision`) VALUES ('$transmicion');";
    $this->ejecutar($sql);
  }

  public function eliminaInterior($id)
  {
    $sql = "DELETE FROM interiores WHERE id = $id;";
    $this->ejecutar($sql);
  }

  public function eliminaMarca($id)
  {
    $sql = "DELETE FROM marca WHERE id = $id;";
    $this->ejecutar($sql);
  }
  public function eliminarModelo($id)
  {
    $sql = "DELETE FROM modelo WHERE id = $id;";
    $this->ejecutar($sql);
  }
  public function eliminaTransmicion($id)
  {
    $sql = "DELETE FROM transmision WHERE id = $id;";
    $this->ejecutar($sql);
  }

  public function dameAutos($id)
  {
    $sql = "SELECT count(id) as conteo from auto WHERE id_marca = $id;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['conteo']);
    }
  }

  function dameInteriores()
  {
    $arregloInteriores = array();
    $sql = "SELECT * FROM interiores;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $interior = new Interior();
      $interior->id = $row['id'];
      $interior->interior = $row['interior'];
      $arregloInteriores[] = $interior;
    }

    return $arregloInteriores;
  }


  function dameInterior($id)
  {
    $sql = "SELECT * FROM interiores WHERE id = $id;";
    $interior = new Interior();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $interior->id = $row['id'];
      $interior->interior = $row['interior'];
    }

    return $interior;
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
    $sql = "SELECT * FROM marca ORDER BY marca;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $marca = new Marca();
      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
      $marca->autos = $this->dameAutos($marca->id);

      $arregloMarca[] = $marca;
    }

    return $arregloMarca;
  }

  function dameMarca($id)
  {

    $sql = "SELECT * FROM marca WHERE id = $id;";
    $marca = new Marca();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $marca->id = $row['id'];
      $marca->marca = $row['marca'];
      $marca->imagen = $row['imagen'];
    }

    return $marca;
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
    $sql = "SELECT * FROM modelo ORDER BY modelo;";

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

    $sql = "SELECT * FROM modelo WHERE id = $id;";
    $modelo = new Modelo();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $modelo->id = $row['id'];
      $modelo->marca = $row['id_marca'];
      $modelo->modelo = $row['modelo'];
    }

    return $modelo;
  }
  function dameTransmiciones()
  {
    $arregloTransmiciones = array();
    $sql = "SELECT * FROM transmision;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $transmicion = new Transmicion();
      $transmicion->id = $row['id'];
      $transmicion->transmicion = $row['transmision'];
      $arregloTransmiciones[] = $transmicion;
    }

    return $arregloTransmiciones;
  }
  function dameTransmicion($id)
  {

    $sql = "SELECT * FROM transmision WHERE id = $id;";
    $transmicion = new Transmicion();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $transmicion->id = $row['id'];
      $transmicion->transmicion = $row['transmision'];
    }
    return $transmicion;
  }
}
