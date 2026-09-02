<?php

include_once('conectorBD.php');
include_once('adminEditor.php');
include_once('adminClientes.php');
include_once('adminPublicaciones.php');


class Auto
{

  public $id;
  public $cilindrage;
  public $descripcion;
  public $marca;
  public $modelo;
  public $transmicion;
  public $anio;
  public $precio;
  public $nacionalidad;
  public $duenio;
  public $estatus;
  public $kilometrage;
  public $combustible;
  public $interiores;
  public $color;
  public $cuerpo;
  public $poder;
  public $asientos;
  public $imagenes;
  public $banner;
  public $pausado;
  public $imagen;
  public $kilometragePermitido;
  public $fecha;

  public function __construct()
  {
    $this->id = 0;
  }
}

class AutoParaApi
{
  public $id;
  public $titulo;
  public $image;
  public $body;
  public $fuel;
  public $transmission;
  public $mileage;
  public $price;

  public function __construct()
  {
    $this->id = 0;
  }
}

class DetallesApi
{
  public $additionalFeatures;
  public $interiorColor;
  public $cilindros;
  public $transmission;
  public $images;

  public function __construct()
  {
    $this->id = 0;
  }
}

class Imagen
{

  public $id;
  public $auto;
  public $url;

  public function __construct()
  {
    $this->id = 0;
  }
}


class AdministradorAutos extends conector
{

  public function agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido)
  {
    $sql = "INSERT INTO `auto` (`cilindrage`, `descripcion`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`, `kilometragePermitido`) 
    VALUES ('$cilindrage', '$descripcion', '$marca', '$modelo', '$transmicion', '$anio', '$precio', '$nacionalidad', '$duenio', 'Semi Nuevo', '$kilometrage', '$combustible', '$interiores', '$color', '$cuerpo', '$poder', '$asientos', 0, 0, '$kilometragePermitido' );";
    $this->ejecutar($sql);
  }
  function recuperarAuto($id)
  {
    $auto = $this->dameAutoRecuperado($id);
    $duenio = $auto->duenio->id;
    $marca = $auto->marca->id;
    $modelo = $auto->modelo->id;
    $transmicion = $auto->transmicion->id;
    $interiores = $auto->interiores->id;
    $sql = "INSERT INTO `auto` (`cilindrage`, `descripcion`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`, `kilometragePermitido`) 
    VALUES ('$auto->cilindrage', '$auto->descripcion', '$marca', '$modelo', '$transmicion', '$auto->anio', '$auto->precio', '$auto->nacionalidad', '$duenio', '$auto->estatus', '$auto->kilometrage', '$auto->combustible', '$interiores', '$auto->color', '$auto->cuerpo', '$auto->poder', '$auto->asientos', 0, 1, '$auto->kilometragePermitido');";
    $this->ejecutar($sql);
    $this->eliminarAutoHistorico($id);
  }

  public function dameUltimoId()
  {
    $sql = "SELECT MAX(id) FROM auto";
    $resultado = $this->ejecutar($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['MAX(id)'];
  }
  public function agregarAutoHistorico($auto)
  {
    $duenio = $auto->duenio->id;
    $marca = $auto->marca->id;
    $modelo = $auto->modelo->id;
    $transmicion = $auto->transmicion->id;
    $interiores = $auto->interiores->id;

    $sql = "INSERT INTO `autoHistorico` (`id_previo` ,`cilindrage`, `descripcion`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`, `kilometragePermitido`) 
    VALUES ('$auto->id','$auto->cilindrage', '$auto->descripcion', '$marca', '$modelo', '$transmicion', '$auto->anio', '$auto->precio', '$auto->nacionalidad', '$duenio', '$auto->estatus', '$auto->kilometrage', '$auto->combustible', '$interiores', '$auto->color', '$auto->cuerpo', '$auto->poder', '$auto->asientos', '$auto->banner', '$auto->pausado', '$auto->kilometragePermitido');";
    $this->ejecutar($sql);
  }
  public function actualizarAuto($id, $cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos)
  {
    $sql = "UPDATE `auto` SET `cilindrage`= '$cilindrage',`descripcion` = '$descripcion',`id_marca` = '$marca',`id_modelo` = '$modelo',
    `id_transmision`= '$transmicion',`anio` = '$anio',`precio` = '$precio',`nacionalidad` = '$nacionalidad',`id_duenio` = '$duenio',`estatus` = '$estatus',
    `kilometrage`='$kilometrage',`combustible` = '$combustible',`id_interiores` = $interiores,`color` = '$color',`cuerpo` = '$cuerpo',`poder` = '$poder',
    `asientos` = '$asientos',`en_banner` = '0' WHERE id = $id;";
    $this->ejecutar($sql);
  }
  public function agregarImagen($auto, $url)
  {
    $sql = "INSERT INTO `imagen` (`id_auto`, `url`) VALUES ('$auto', '$url');";
    $this->ejecutar($sql);
  }

  public function asignarPortada($id, $auto)
  {
    $sql = "UPDATE `auto` SET `imagen` = '$id' WHERE id = $auto;";
    $this->ejecutar($sql);
  }

  public function dameImgenes($id)
  {

    $arrelgoImagenes = array();
    $sql = "SELECT * FROM imagen WHERE id_auto = $id";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $imagen = new Imagen();
      $imagen->id = $row['id'];
      $imagen->auto = $row['id_auto'];
      $imagen->url = $row['url'];
      $arrelgoImagenes[] = $imagen;
    }

    return $arrelgoImagenes;
  }

  public function dameImgenesUrl($id)
  {

    $arrelgoImagenes = array();
    $sql = "SELECT * FROM imagen WHERE id_auto = $id";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $imagen = new Imagen();
      $arrelgoImagenes[] = "https://seminuevosharo.mx" . $row['url'];
    }

    return $arrelgoImagenes;
  }

  public function dameImgenesTotal()
  {

    $arrelgoImagenes = array();
    $sql = "SELECT * FROM imagen;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $imagen = new Imagen();
      $imagen->id = $row['id'];
      $imagen->auto = $row['id_auto'];
      $imagen->url = $row['url'];
      $arrelgoImagenes[] = $imagen;
    }

    return $arrelgoImagenes;
  }
  public function dameImgen($id)
  {


    $sql = "SELECT * FROM imagen WHERE id = $id;";
    $imagen = new Imagen();
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $imagen->id = $row['id'];
      $imagen->auto = $row['id_auto'];
      $imagen->url = $row['url'];
    }

    return $imagen;
  }

  function eliminarAuto($id)
  {
    $auto = $this->dameAuto($id);
    if (!$auto->imagen) {
      $this->asignarPortada($auto->imagenes[0]->id, $id);
      for ($i = 1; $i < count($auto->imagenes); $i++) {
        $this->eliminarImagen($auto->imagenes[$i]->id);
      }
    } else {
      for ($i = 0; $i < count($auto->imagenes); $i++) {
        if ($auto->imagenes[$i]->url != $auto->imagen) {
          $this->eliminarImagen($auto->imagenes[$i]->id);
        }
      }
    }
    $this->agregarAutoHistorico($auto);

    $sql = "DELETE FROM auto WHERE id = $id";
    $this->ejecutar($sql);
  }

  function eliminarAutoHistorico($id)
  {
    $sql = "DELETE FROM autoHistorico WHERE id = $id";
    $this->ejecutar($sql);
  }

  function borrarImagen($id)
  {
    $imagen = $this->dameImgen($id);
    unlink($_SERVER['DOCUMENT_ROOT'] . $imagen->url);
  }
  function eliminarImagen($id)
  {
    $sql = "DELETE FROM imagen WHERE id = $id";
    $this->borrarImagen($id);
    $this->ejecutar($sql);
  }




  function dameAuto($id)
  {
    $adminEditor = new AdministradorEditor();
    $adminCliente = new AdministradorClientes();
    $auto = new Auto();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `kilometragePermitido` FROM `auto` WHERE id = $id;";


    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->imagen = $row['imagen'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }

      $auto->imagenes = $this->dameImgenes($auto->id);
    }

    return $auto;
  }




  function dameAutosApiBuscados($palabra)
  {

    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM `auto` WHERE id_modelo in (SELECT modelo.id
    FROM marca
    INNER JOIN modelo
    ON marca.id = modelo.id_marca
    WHERE marca.marca LIKE '%$palabra%' or modelo.modelo LIKE '%$palabra%')
    and pausado = 0;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new AutoParaApi();

      $imagenes = $this->dameImgenes($row['id']);
      $auto->id = $row['id'];
      $auto->titulo = "Esto es una prueba De HARO";
      $auto->image = "https://seminuevosharo.mx" . $row['imagen'];
      $auto->body = $row['cuerpo'];
      $auto->fuel = $row['combustible'];
      $auto->price = $row['precio'];
      $auto->transmission = $adminEditor->dameTransmicion($row['id_transmision'])->transmicion;
      $auto->mileage = $row['kilometrage'];
      $auto->price = $row['precio'];

      if (!strlen($row['imagen'])) {
        $auto->image = "https://seminuevosharo.mx" . $imagenes[0]->url;
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }



  function dameAutosApiRango($min, $max)
  {

    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM auto WHERE precio BETWEEN $min AND $max;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new AutoParaApi();

      $imagenes = $this->dameImgenes($row['id']);
      $auto->id = $row['id'];
      $auto->titulo = "Esto es una prueba De HARO";
      $auto->image = "https://seminuevosharo.mx" . $row['imagen'];
      $auto->body = $row['cuerpo'];
      $auto->fuel = $row['combustible'];
      $auto->price = $row['precio'];
      $auto->transmission = $adminEditor->dameTransmicion($row['id_transmision'])->transmicion;
      $auto->mileage = $row['kilometrage'];
      $auto->price = $row['precio'];

      if (!strlen($row['imagen'])) {
        $auto->image = "https://seminuevosharo.mx" . $imagenes[0]->url;
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameDetallesApi($id)
  {

    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM `auto` WHERE id = $id;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new DetallesApi();
      $auto->additionalFeatures = $row['descripcion'];
      $auto->interiorColor = $row['color'];
      $auto->cilindros = $row['cilindrage'];
      $auto->transmission = $adminEditor->dameTransmicion($row['id_transmision'])->transmicion;
      $auto->images = $this->dameImgenesUrl($row['id']);
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosApi($palabra, $minimo, $maximo)
  {

    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM `auto` WHERE id_modelo in (SELECT modelo.id
    FROM marca
    INNER JOIN modelo
    ON marca.id = modelo.id_marca
    WHERE marca.marca LIKE '%$palabra%' or modelo.modelo LIKE '%$palabra%')
    and pausado = 0 and precio BETWEEN $minimo AND $maximo ORDER BY precio;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new AutoParaApi();
      $marca = $adminEditor->dameMarca($row['id_marca'])->marca;
      $modelo = $adminEditor->dameModelo($row['id_modelo'])->modelo;
      $imagenes = $this->dameImgenes($row['id']);
      $auto->id = $row['id'];
      $auto->titulo = $marca . " " . $modelo . " " . $row['anio'];
      $auto->image = "https://seminuevosharo.mx" . $row['imagen'];
      $auto->body = $row['cuerpo'];
      $auto->fuel = $row['combustible'];
      $auto->price = $row['precio'];
      $auto->transmission = $adminEditor->dameTransmicion($row['id_transmision'])->transmicion;
      $auto->mileage = $row['kilometrage'] . " KM ";
      $auto->price = $row['precio'];

      if (!strlen($row['imagen'])) {
        $auto->image = "https://seminuevosharo.mx" . $imagenes[0]->url;
      }
      if($auto->price == 0){
        $auto->price = "0";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutoRecuperado($id)
  {
    $adminEditor = new AdministradorEditor();
    $adminCliente = new AdministradorClientes();
    $auto = new Auto();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `kilometragePermitido` FROM `autoHistorico` WHERE id = $id;";


    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {

      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->imagen = $row['imagen'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }

      $auto->imagenes = $this->dameImgenes($auto->id);
    }

    return $auto;
  }


  function colocarBanner($id)
  {
    $sql = "UPDATE auto SET en_banner = 1 WHERE id = $id;";
    $this->ejecutar($sql);
  }

  function quitarBanner($id)
  {
    $sql = "UPDATE auto SET en_banner = 0 WHERE id = $id;";
    $this->ejecutar($sql);
  }

  function dameUltimosAutos()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`
     FROM `auto` WHERE  `en_banner` = 1;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->imagen = $row['imagen'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function cuentaAutos()
  {

    $sql = "select count(id) as suma from auto;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['suma']);
    }
  }
  function dameMaximoPrecio()
  {
    $sql = "SELECT MAX(precio) as maximo from auto;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['maximo']);
    }
  }
  function dameAutosBuscados($palabra)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM `auto` WHERE id_modelo in (SELECT modelo.id
    FROM marca
    INNER JOIN modelo
    ON marca.id = modelo.id_marca
    WHERE marca.marca LIKE '%$palabra%' or modelo.modelo LIKE '%$palabra%')
    and pausado = 0;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->imagen = $row['imagen'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }

      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameMenorPrecio()
  {
    $sql = "SELECT MIN(precio) as minimo from auto;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['minimo']);
    }
  }
  public function dameMaximoMinimo()
  {
    $arregloMaximosMinimo = array();
    $arregloMaximosMinimo[] = $this->dameMaximoPrecio();
    $arregloMaximosMinimo[] = $this->dameMenorPrecio();
    return $arregloMaximosMinimo;
  }

  function dameAutosMarca($marca)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
     FROM `auto` WHERE  `id_marca` = '$marca';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->imagen = $row['imagen'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }


  function dameAutosMarcaCarH($marca)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT auto.id,`cilindrage`, `descripcion`, auto.imagen, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
      FROM `auto`
 	    INNER JOIN marca
      ON auto.id_marca = marca.id
      WHERE  marca.marca LIKE '%$marca%';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->imagen = $row['imagen'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }
  function dameAutosCombustible($combustible)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
     FROM `auto` WHERE  `combustible` = '$combustible';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->imagen = $row['imagen'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosBusqueda($marca, $modelo, $estatus, $transmicion, $combustible)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`
     FROM `auto` WHERE  id_marca = $marca and id_modelo = $modelo and estatus = '$estatus' and id_transmision = $transmicion and combustible = '$combustible';";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->imagen = $row['imagen'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }


  function dameAutosNoSubidos($redSocial)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $adminPublicaciones = new AdministradorPublicaciones();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` ORDER BY id desc;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->imagen = $row['imagen'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      if (!$adminPublicaciones->existepublicacionPorRedSocialYa($redSocial, $auto->id)) {
        if ($auto->pausado == 0) {
          $arregloAutos[] = $auto;
        }
      }
    }

    return $arregloAutos;
  }

  function dameHistorico()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `id_previo`
     FROM `autoHistorico` ORDER BY id desc;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->imagen = $row['imagen'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];
      $auto->fecha = $row['fecha_eliminacion'];
      $auto->imagenes = $this->dameImgenes($row['id_previo']);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosSinPausar()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` ORDER BY id desc;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->imagen = $row['imagen'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      if ($auto->pausado == 0) {
        $arregloAutos[] = $auto;
      }
    }

    return $arregloAutos;
  }


  function dameAutos()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` ORDER BY id desc;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->imagen = $row['imagen'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }


  function dameAutosPaginacion($pagina)
  {
    $paginaS = 5;
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = 'SELECT `id`,`cilindrage`, `descripcion`,  `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` ORDER BY precio  LIMIT 5 OFFSET ' . (($pagina - 1) * $paginaS) . ';';

    //echo $sql;
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->imagen = $row['imagen'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->pausado = $row['pausado'];
      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosPorPrecio($min, $max)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM auto WHERE precio BETWEEN $min AND $max;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      $auto = new Auto();
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $adminEditor->dameMarca($row['id_marca']);
      $auto->modelo = $adminEditor->dameModelo($row['id_modelo']);
      $auto->transmicion = $adminEditor->dameTransmicion($row['id_transmision']);
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $adminCliente->getCliente($row['id_duenio']);
      $auto->estatus = $row['estatus'];
      $auto->imagen = $row['imagen'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $adminEditor->dameInterior($row['id_interiores']);
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->kilometragePermitido = $row['kilometragePermitido'];

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }
  public function pausar($id)
  {
    $sql = "UPDATE auto SET pausado = 1 WHERE id = $id;";
    $this->ejecutar($sql);
  }
  public function asignarAuto($id, $auto)
  {
    $sql = "UPDATE imagen SET id_auto = $auto WHERE id = $id;";
    $this->ejecutar($sql);
  }
  public function despausar($id)
  {
    $sql = "UPDATE auto SET pausado = 0 WHERE id = $id;";
    $this->ejecutar($sql);
  }
}
