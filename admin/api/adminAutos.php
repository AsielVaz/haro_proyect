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
  public $consig;
  public $idAlmacen;
  public $almacenVerificado;

  public function __construct()
  {
    $this->id = 0;
    $this->imagenes = [];
    $this->imagen = '';
    $this->pausado = 0;
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


class LogCambioAuto
{ //SELECT `id`, `ip`, `mensaje`, `ultima_act`, `id_auto` FROM `log_cambio_auto` WHERE 1
  public $id;
  public $ip;
  public $mensaje;
  public $ultima_act;
  public $id_auto;
  public $nombre_usuario;

  public function __construct()
  {
    $this->id = 0;
  }
}

class AdministradorAutos extends conector
{
  private ?array $imagenesPorAuto = null;
  private array $imagenesTodas = [];
  private bool $cacheImagenesCompleta = false;
  private int $consultasImagenIndividual = 0;

  private function cargarCacheImagenes(): void
  {
    if ($this->cacheImagenesCompleta) {
      return;
    }

    $this->imagenesPorAuto = [];
    $this->imagenesTodas = [];
    $result = $this->ejecutar("SELECT `id`, `id_auto`, `url` FROM `imagen`");
    while ($row = $result->fetch_assoc()) {
      $imagen = new Imagen();
      $imagen->id = $row['id'];
      $imagen->auto = $row['id_auto'];
      $imagen->url = $row['url'];
      $this->imagenesPorAuto[(int) $row['id_auto']][] = $imagen;
      $this->imagenesTodas[] = $imagen;
    }
    $this->cacheImagenesCompleta = true;
  }

  private function invalidarCacheImagenes(): void
  {
    $this->imagenesPorAuto = null;
    $this->imagenesTodas = [];
    $this->cacheImagenesCompleta = false;
    $this->consultasImagenIndividual = 0;
  }

  public function agregarAuto($cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $kilometragePermitido, $consig, $idAlmacen = 0)
  {
    $sql = "INSERT INTO `auto` (`cilindrage`, `descripcion`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`, `kilometragePermitido`, `consig`, `id_almacen`) 
    VALUES ('$cilindrage', '$descripcion', '$marca', '$modelo', '$transmicion', '$anio', '$precio', '$nacionalidad', '$duenio', 'Semi Nuevo', '$kilometrage', '$combustible', '$interiores', '$color', '$cuerpo', '$poder', '$asientos', 0, 0, '$kilometragePermitido', '$consig', '$idAlmacen' );";
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

  public function renovarAuto($id)
  {
    $ultimaId = $this->dameUltimoId();
    $ultimaId++;
    $sql = "UPDATE `auto` SET `id` = $ultimaId, notificado = 0 WHERE `id` = $id;";
    $this->ejecutar($sql);
    $sql = "update imagen set id_auto =$ultimaId where id_auto = $id;";
    $this->ejecutar($sql);
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
  public function agregarAutoVenta($auto)
  {
    $duenio = $auto->duenio;
    $marca = $auto->marca;
    $modelo = $auto->modelo;
    $transmicion = $auto->transmicion;
    $interiores = $auto->interiores;

    $sql = "INSERT INTO `autoVentas` (`id_previo` ,`cilindrage`, `descripcion`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`, `kilometragePermitido`, `imagen`) 
    VALUES ('$auto->id','$auto->cilindrage', '$auto->descripcion', '$marca', '$modelo', '$transmicion', '$auto->anio', '$auto->precio', '$auto->nacionalidad', '$duenio', '$auto->estatus', '$auto->kilometrage', '$auto->combustible', '$interiores', '$auto->color', '$auto->cuerpo', '$auto->poder', '$auto->asientos', '$auto->banner', '$auto->pausado', '$auto->kilometragePermitido', '$auto->imagen');";
    //echo $sql;
    $this->ejecutar($sql);
  }
  public function actualizarAuto($id, $cilindrage, $descripcion, $marca, $modelo, $transmicion, $anio, $precio, $nacionalidad, $duenio, $estatus, $kilometrage, $combustible, $interiores, $color, $cuerpo, $poder, $asientos, $consig, $idAlmacen)
  {
    $sql = "UPDATE `auto` SET `cilindrage`= '$cilindrage',`descripcion` = '$descripcion',`id_marca` = '$marca',`id_modelo` = '$modelo',
    `id_transmision`= '$transmicion',`anio` = '$anio',`precio` = '$precio',`nacionalidad` = '$nacionalidad',`id_duenio` = '$duenio',`estatus` = '$estatus',
    `kilometrage`='$kilometrage',`combustible` = '$combustible',`id_interiores` = $interiores,`color` = '$color',`cuerpo` = '$cuerpo',`poder` = '$poder',
    `asientos` = '$asientos',`en_banner` = '0', `consig` = '$consig', `id_almacen` = '$idAlmacen' WHERE id = $id;";
    $this->ejecutar($sql);
    //SELECT `id`, `ip`, `mensaje`, `ultima_act` FROM `log_cambio_auto` WHERE 1
    $sqlLog = "INSERT INTO `log_cambio_auto` (`id_auto`, `ip`, `mensaje`, `ultima_act`) VALUES ('$id', '" . $_SERVER['REMOTE_ADDR'] . "', 'El auto con id $id ha sido actualizado', now());";
    $this->ejecutar($sqlLog);
  }
  public function agregarImagen($auto, $url)
  {
    $sql = "INSERT INTO `imagen` (`id_auto`, `url`) VALUES ('$auto', '$url');";
    $this->ejecutar($sql);
    $this->invalidarCacheImagenes();
  }

  public function asignarPortada($id, $auto)
  {
    $sql = "UPDATE `auto` SET `imagen` = '$id' WHERE id = $auto;";
    $this->ejecutar($sql);
  }

  public function dameImgenes($id)
  {
    $id = (int) $id;
    if ($this->imagenesPorAuto !== null && array_key_exists($id, $this->imagenesPorAuto)) {
      return $this->imagenesPorAuto[$id];
    }
    if ($this->cacheImagenesCompleta) {
      return [];
    }

    if ($this->consultasImagenIndividual === 0) {
      $this->imagenesPorAuto ??= [];
      $this->imagenesPorAuto[$id] = [];
      $result = $this->ejecutar("SELECT `id`, `id_auto`, `url` FROM `imagen` WHERE `id_auto` = $id");
      while ($row = $result->fetch_assoc()) {
        $imagen = new Imagen();
        $imagen->id = $row['id'];
        $imagen->auto = $row['id_auto'];
        $imagen->url = $row['url'];
        $this->imagenesPorAuto[$id][] = $imagen;
      }
      $this->consultasImagenIndividual++;
      return $this->imagenesPorAuto[$id];
    }

    $this->cargarCacheImagenes();
    return $this->imagenesPorAuto[$id] ?? [];
  }

  public function dameImgenesTotal()
  {
    $this->cargarCacheImagenes();
    return $this->imagenesTodas;
  }


  public function dameImagenesSinAuto()
  {
    $arrelgoImagenes = array();
    $sql = "SELECT * FROM imagen WHERE id_auto = 0 order by id desc;";

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
    $sql = "UPDATE `auto` SET vendido = 1, fecha_venta= now(), en_banner = 0, pausado=1, consig=0 where id = $id;";
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
    $this->invalidarCacheImagenes();
  }

  function dameAutoMarcaYModelo($marca, $modelo)
  {
    $adminEditor = new AdministradorEditor();
    $adminCliente = new AdministradorClientes();
    $auto = new Auto();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `kilometragePermitido` FROM `auto` WHERE id_marca = $marca AND id_modelo = $modelo AND vendido = 0 ;";


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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }

      $auto->imagenes = $this->dameImgenes($auto->id);
    }

    return $auto;
  }

  function dameAutoLite($id)
  {
    $sql = "select * from auto where id = $id ;";
    $result = $this->ejecutar($sql);
    $auto = new Auto();
    while ($row = $result->fetch_assoc()) {
      $auto->id = $row['id'];
      $auto->cilindrage = $row['cilindrage'];
      $auto->descripcion = $row['descripcion'];
      $auto->marca = $row['id_marca'];
      $auto->modelo = $row['id_modelo'];
      $auto->transmicion = $row['id_transmision'];
      $auto->anio = $row['anio'];
      $auto->precio = $row['precio'];
      $auto->nacionalidad = $row['nacionalidad'];
      $auto->duenio = $row['id_duenio'];
      $auto->estatus = $row['estatus'];
      $auto->kilometrage = $row['kilometrage'];
      $auto->combustible = $row['combustible'];
      $auto->interiores = $row['id_interiores'];
      $auto->color = $row['color'];
      $auto->cuerpo = $row['cuerpo'];
      $auto->poder = $row['poder'];
      $auto->asientos = $row['asientos'];
      $auto->banner = $row['en_banner'];
      $auto->pausado = $row['pausado'];
      $auto->imagen = $row['imagen'];
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
    }
    return $auto;
  }


  function dameAutoConImagenes($id)
  {
    $adminEditor = new AdministradorEditor();
    $adminCliente = new AdministradorClientes();
    $auto = new Auto();
    $sql = "SELECT 
    a.`id`,
    a.`cilindrage`,
    a.`descripcion`,
    a.`imagen`,
    a.`id_marca`,
    a.`id_modelo`,
    a.`id_transmision`,
    a.`anio`,
    a.`precio`,
    a.`nacionalidad`,
    a.`id_duenio`,
    a.`estatus`,
    a.`kilometrage`,
    a.`combustible`,
    a.`id_interiores`,
    a.`color`,
    a.`cuerpo`,
    a.`poder`,
    a.`asientos`,
    a.`en_banner`,
    a.`pausado`,
    a.`kilometragePermitido`,
    a.`consig`
FROM `auto` a
WHERE a.`id` = $id
AND EXISTS (
    SELECT 1
    FROM `imagen` i
    WHERE i.`id_auto` = a.`id`
);";


    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();

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
    $auto->consig = $row['consig'];
    $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
    if ($auto->kilometrage <= 0) {
      $auto->kilometrage = "N/E ";
    }

    $auto->imagenes = $this->dameImgenes($auto->id);


    return $auto;
  }

  function dameAuto($id)
  {
    $adminEditor = new AdministradorEditor();
    $adminCliente = new AdministradorClientes();
    $auto = new Auto();
    $id = (int) $id;
    if ($id < 1) {
      return $auto;
    }
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `kilometragePermitido` , `consig` FROM `auto` WHERE id = $id;";


    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
      return $auto;
    }

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
    $auto->consig = $row['consig'];
    $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
    if ($auto->kilometrage <= 0) {
      $auto->kilometrage = "N/E ";
    }

    $auto->imagenes = $this->dameImgenes($auto->id);


    return $auto;
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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
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
     FROM `auto` WHERE  `en_banner` = 1  and pausado = 0 AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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

    $sql = "select count(id) as suma from auto WHERE pausado = 0 and vendido = 0;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['suma']);
    }
  }

  function cuentaImagenesAuto($auto)
  {

    $sql = "select count(id) as suma from imagen WHERE id_auto = $auto;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['suma']);
    }
  }

  function cuentaAutosPorMarca($id)
  {

    $sql = "select count(id) as suma from auto where id_marca = $id AND pausado = 0;";

    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['suma']);
    }
  }

  function dameMaximoPrecio()
  {
    $sql = "SELECT MAX(precio) as maximo from auto where vendido = 0;";
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
    $palabra = $this->escapar((string) $palabra);
    $sql = "SELECT a.*
      FROM `auto` a
      INNER JOIN `modelo` mo ON mo.`id` = a.`id_modelo`
      INNER JOIN `marca` ma ON ma.`id` = mo.`id_marca`
      WHERE (ma.`marca` LIKE '%$palabra%' OR mo.`modelo` LIKE '%$palabra%')
        AND a.`pausado` = 0 AND a.`vendido` = 0;";
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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }

      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosPorAnio($min, $max)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $min = max(1900, (int) $min);
    $max = max($min, (int) $max);
    $sql = "SELECT * FROM `auto` WHERE anio >= $min AND anio <= $max AND pausado = 0 AND vendido = 0;";
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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $sql = "SELECT MIN(precio) as minimo from auto WHERE precio > 0 and vendido = 0;";
    $result = $this->ejecutar($sql);
    while ($row = $result->fetch_assoc()) {
      return intval($row['minimo']);
    }
  }
  public function dameMaximoMinimo()
  {
    $sql = "SELECT MAX(precio) AS maximo,
      MIN(CASE WHEN precio > 0 THEN precio END) AS minimo
      FROM auto WHERE vendido = 0";
    $row = $this->ejecutar($sql)->fetch_assoc();
    return [(int) $row['maximo'], (int) $row['minimo']];
  }

  function dameAutosMarca($marca)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $marca = (int) $marca;
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
     FROM `auto` WHERE `id_marca` = $marca AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $marca = $this->escapar((string) $marca);
    $sql = "SELECT auto.id,`cilindrage`, `descripcion`, auto.imagen, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
      FROM `auto`
 	    INNER JOIN marca
      ON auto.id_marca = marca.id
      WHERE  marca.marca LIKE '%$marca%' AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $combustible = $this->escapar((string) $combustible);
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner` ,`pausado`
     FROM `auto` WHERE  `combustible` = '$combustible' AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $marca = (int) $marca;
    $modelo = (int) $modelo;
    $transmicion = (int) $transmicion;
    $estatus = $this->escapar((string) $estatus);
    $combustible = $this->escapar((string) $combustible);
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos`, `en_banner`, `pausado`
     FROM `auto` WHERE  id_marca = $marca and id_modelo = $modelo and estatus = '$estatus' and id_transmision = $transmicion and combustible = '$combustible' AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $arregloAutos = array();
    $redSocial = $this->escapar((string) $redSocial);
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` a
     WHERE a.`pausado` = 0
       AND NOT EXISTS (
         SELECT 1 FROM `publicaciones` p
         WHERE p.`auto` = a.`id` AND p.`red_social` = '$redSocial'
       )
     ORDER BY id desc;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameHistorico()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `id_previo`, `fecha_eliminacion`, `kilometragePermitido`
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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
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
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `id_almacen`, `almacen_verificado`
     FROM `auto` WHERE vendido = 0 AND pausado = 0 ORDER BY id desc;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
      $auto->idAlmacen = $row['id_almacen'];
      $auto->almacenVerificado = $row['almacen_verificado'];
      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosApp()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`, `id_almacen`, `almacen_verificado`
     FROM `auto` WHERE  vendido = 0 ORDER BY id desc;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;
      $auto->idAlmacen = $row['id_almacen'];
      $auto->almacenVerificado = $row['almacen_verificado'];
      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosConDiasDeSuvido($dias)
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    // dia de hoy
    $fecha = date('d') + 1;

    $resta = $fecha - $dias;
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` WHERE DAY(fecha_subido) < $resta AND vendido = 0 AND pausado = 0 ORDER BY id desc;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }


  function dameAutosConsignacion()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado` , `consig`
     FROM `auto` WHERE consig = 1 ORDER BY id desc;";

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
      $auto->consig = $row['consig'];
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->imagen == "" && isset($auto->imagenes[0])) {
        $auto->imagen = $auto->imagenes[0]->url;
      }
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }
  function dameAutos()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado` , `consig`
     FROM `auto` WHERE vendido = 0 ORDER BY id desc;";

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
      $auto->consig = $row['consig'];
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->imagen == "" && isset($auto->imagenes[0])) {
        $auto->imagen = $auto->imagenes[0]->url;
      }
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }



  function marcaNotificados($auto)
  {
    $sql = "UPDATE `auto` SET `notificado`= 1 WHERE id = $auto;";
    $this->ejecutar($sql);
  }

  function dameAutosSinNotificar()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado` , `consig`
     FROM `auto` WHERE vendido = 0 and notificado = 0 ORDER BY id desc limit 1;";

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
      $auto->consig = $row['consig'];
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->imagen == "" && isset($auto->imagenes[0])) {
        $auto->imagen = $auto->imagenes[0]->url;
      }
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function dameAutosVendidos()
  {
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT `id`,`cilindrage`, `descripcion`, `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado` , `consig`
     FROM `auto` WHERE vendido = 1 ORDER BY id desc;";

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
      $auto->consig = $row['consig'];
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->imagen == "" && isset($auto->imagenes[0])) {
        $auto->imagen = $auto->imagenes[0]->url;
      }
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }


  function dameAutosPaginacion($pagina)
  {
    $pagina = max(1, (int) $pagina);
    $paginaS = 6;
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = 'SELECT `id`,`cilindrage`, `descripcion`,  `imagen`, `id_marca`, `id_modelo`, `id_transmision`, `anio`, `precio`, `nacionalidad`, `id_duenio`, 
    `estatus`, `kilometrage`, `combustible`, `id_interiores`, `color`, `cuerpo`, `poder`, `asientos` , `en_banner`, `pausado`
     FROM `auto` WHERE pausado = 0 AND vendido = 0 AND consig= 0 ORDER BY precio LIMIT 6 OFFSET ' . (($pagina - 1) * $paginaS) . ';';

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

      $auto->pausado = $row['pausado'];
      $auto->imagenes = $this->dameImgenes($auto->id);
      if ($auto->kilometrage <= 0) {
        $auto->kilometrage = "N/E ";
      }
      $arregloAutos[] = $auto;
    }

    return $arregloAutos;
  }

  function cuentaAutosHistorico()
  {
    $sql = "SELECT count(*) as cuenta FROM `autoHistorico`;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    return $row['cuenta'];
  }

  function dameAutosPorPrecio($min, $max)
  {
    $min = max(0, (int) $min);
    $max = max($min, (int) $max);
    $adminCliente = new AdministradorClientes();
    $adminEditor = new AdministradorEditor();
    $arregloAutos = array();
    $sql = "SELECT * FROM auto WHERE precio BETWEEN $min AND $max AND vendido = 0;";

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
      $auto->kilometragePermitido = $row['kilometragePermitido'] ?? 0;

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
    $this->invalidarCacheImagenes();
  }
  public function despausar($id)
  {
    $sql = "UPDATE auto SET pausado = 0 WHERE id = $id;";
    $this->ejecutar($sql);
  }

  public function sumaMontosAutos()
  {
    $sql = "SELECT SUM(precio) as suma FROM `auto` where consig = 0;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    return $row['suma'];
  }

  public function cuentaAutosValidos()
  {
    $sql = "SELECT count(*) as cuenta FROM `auto` where consig = 0;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    return $row['cuenta'];
  }

  public function dameAnioMasAlto()
  {
    $sql = "SELECT MAX(anio) as anio FROM `auto` where  pausado = 0 AND vendido = 0;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    return $row['anio'];
  }
  public function dameAnioMasBajo()
  {
    $sql = "SELECT MIN(anio) as anio FROM `auto`  where  pausado = 0 AND vendido = 0;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    return $row['anio'];
  }

  public function dameRangoAnios(): array
  {
    $sql = "SELECT MIN(anio) AS minimo, MAX(anio) AS maximo
      FROM auto WHERE pausado = 0 AND vendido = 0";
    $row = $this->ejecutar($sql)->fetch_assoc();
    return [$row['minimo'], $row['maximo']];
  }

  public function dameUltimoLog()
  {
    $sql = "SELECT `id`,`id_auto`, `mensaje`, `ultima_act` FROM `log_cambio_auto` ORDER BY id desc limit 1;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    $log = new  logCambioAuto();
    $log->id = $row['id'];
    $log->id_auto = $row['id_auto'];
    $log->mensaje = $row['mensaje'];
    $log->ultima_act = $row['ultima_act'];
    return $log;
  }

  public function dameUltimoLogAuto($id)
  {
    //SELECT `id`, `ip`, `mensaje`, `ultima_act`, `id_auto` FROM `log_cambio_auto` WHERE 1
    $sql = "SELECT `id`, `ip`, `mensaje`, `ultima_act`, `id_auto` FROM `log_cambio_auto` WHERE id_auto = $id ORDER BY id desc limit 1;";
    $result = $this->ejecutar($sql);
    $row = $result->fetch_assoc();
    $log = new logCambioAuto();
    $log->id = $row['id'];
    $log->id_auto = $row['id_auto'];
    $log->mensaje = $row['mensaje'];
    $log->ultima_act = $row['ultima_act'];
    $log->ip = $row['ip'];
    return $log;
  }

  public function dameLogsAuto($id_auto)
  {
    $sql = "SELECT log_cambio_auto.`id`, `ip`, `mensaje`, `ultima_act`, `id_auto`, `id_usuario`, `nombre` FROM `log_cambio_auto` 
    left join usuario  on log_cambio_auto.id_usuario = usuario.id
    WHERE id_auto = $id_auto ORDER BY id desc;";
    $result = $this->ejecutar($sql);
    $logs = array();
    while ($row = $result->fetch_assoc()) {
      $log = new logCambioAuto();
      $log->id = $row['id'];
      $log->id_auto = $row['id_auto'];
      $log->mensaje = "El usuario " . $row['nombre'] . " ha realizado un cambio: " . $row['mensaje'];
      $log->ultima_act = $row['ultima_act'];
      $log->ip = $row['ip'];
      $log->nombre_usuario = $row['nombre'];
      $logs[] = $log;
    }
    return $logs;
  }

  public function verificarAlmacen($id_auto, $id_usuario)
  {
    $sql = "UPDATE auto SET almacen_verificado = 1 WHERE id = $id_auto;";
    $this->ejecutar($sql);
    $sqlLog = "INSERT INTO `log_cambio_auto`(`id_auto`, `mensaje`, `ip`, `id_usuario`) VALUES ($id_auto, 'Almacen verificado', '" . $_SERVER['REMOTE_ADDR'] . "', $id_usuario);";
    $this->ejecutar($sqlLog);
  }


  public function obtenerAutosParaAsignarPortada()
  {
    $sql = "SELECT a.id, a.fecha_cap,
      (SELECT i.url FROM imagen i WHERE i.id_auto = a.id ORDER BY i.id ASC LIMIT 1) AS primera_imagen
      FROM auto a
      WHERE (a.imagen IS NULL OR a.imagen = '')
        AND EXISTS (SELECT 1 FROM imagen i WHERE i.id_auto = a.id)";
    $result = $this->ejecutar($sql);
    $autos = [];
    while ($row = $result->fetch_object()) {
      $autos[] = $row;
    }
    return $autos;
  }

  public function asignarPortadaAuto($idAuto, $rutaImagen)
  {
    $idAuto = (int) $idAuto;
    $rutaImagen = $this->escapar((string) $rutaImagen);
    return $this->ejecutar("UPDATE auto SET imagen = '$rutaImagen' WHERE id = $idAuto");
  }
}
