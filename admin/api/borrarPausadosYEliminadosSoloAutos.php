<?php

include_once('conectorBD.php');

class Pausado
{

    public $idPublicacion;
    public $redSocial;
    public $pausado;

    public function __construct()
    {
        $this->idPublicacion = "";
    }
}

class Eliminado
{

    public $idPublicacion;
    public $redSocial;
    public $idAuto;

    public function __construct()
    {
        $this->idPublicacion = "";
    }
}


class AdminEliminar extends conector
{

    // esta funcion elimina la publicacion de solo autos para los autos que estan pausados
    function dameIdPublicacionSoloAutosPausados()
    {
        $publicacion = array();
        $sql = "SELECT publicaciones.id_publicacion, publicaciones.red_social, auto.pausado 
        FROM `publicaciones`
        INNER JOIN auto 
        ON publicaciones.auto = auto.id 
        WHERE publicaciones.red_social = 'soloAutos' AND auto.pausado = 1;";
        $result = $this->ejecutar($sql);
        while ($row = $result->fetch_assoc()) {
            $pausado = new Pausado();
            $pausado->idPublicacion = $row['id_publicacion'];
            $pausado->redSocial = $row['red_social'];
            $pausado->pausado = $row['pausado'];
            $publicacion[] = $pausado;
        }
        return $publicacion;
    }

    // esta funcion elimina la publicacion de solo autos para los autos que estan eliminados
    function dameIdPublicacionSoloAutosEliminados()
    {
        $publicacion = array();
        $sql = "SELECT publicaciones.id_publicacion, publicaciones.red_social, autoHistorico.id 
        FROM publicaciones 
        INNER JOIN autoHistorico 
        ON publicaciones.auto = autoHistorico.id 
        WHERE publicaciones.red_social = 'soloAutos';";
        $result = $this->ejecutar($sql);
        while ($row = $result->fetch_assoc()) {
            $eliminado = new Eliminado();
            $eliminado->idPublicacion = $row['id_publicacion'];
            $eliminado->redSocial = $row['red_social'];
            $eliminado->idAuto = $row['id'];
            $publicacion[] = $eliminado;
        }
        return $publicacion;
    }
}

$adminEliminar = new AdminEliminar();
// $publicaciones = $adminEliminar->dameIdPublicacionSoloAutosPausados();
$publicacionesEliminadas = $adminEliminar->dameIdPublicacionSoloAutosEliminados();

// eliminar publicaciones de la api de solo autos para los autos que estan pausados

function accionEliminar($publicaciones)
{
    foreach ($publicaciones as $publicacion) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://id.csnglobal.net/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id=d2b99996-388f-4fa2-9998-5688f89bbb3b&client_secret=+vUBc/9FNguhQLrelDHtKTpE80AL+rn12FWy+nm6RQM=&grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: csncidcf=7937389A-C266-4D03-9183-939E66578918'
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $token = json_decode($response)->access_token;
        $curlDel = curl_init();

        curl_setopt_array($curlDel, array(
            CURLOPT_URL => 'https://inventory.api.carsales.com/v1/vehicles/' . $publicacion->idPublicacion,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'accept: */*',
                'Authorization: Bearer ' . $token,
                'x-seller-identifier: 65044C3C-7D96-11E9-A279-02A648AAD720',
                'Cookie: csncidcf=69DB9F96-EB3A-49F9-A600-50504FA6627E'
            ),
        ));

        $responseDel = curl_exec($curlDel);
        $httpcodeDel = curl_getinfo($curlDel, CURLINFO_HTTP_CODE);

        curl_close($curlDel);
        echo $httpcodeDel;
        // contar las publicaciones eliminadas
        $contador = 0;
        if ($httpcodeDel == 202 || $httpcodeDel == 404) {
            $contador++;
        }
        echo $contador;
    }
}

accionEliminar($publicacionesEliminadas);

// contar publicaciones Eliminadas
$contarPublicacionesEliminadas = count($publicacionesEliminadas);
echo $contarPublicacionesEliminadas;



// eliminar publicaciones de la api de solo autos para los autos que estan eliminados