<?php
include_once("adminPublicaciones.php");
$redSocial = $_POST['redSocial'];
$idAuto = $_POST['id_auto'];
$id_publicacion = $_POST['idPublicacion'];

if (isset($redSocial) && isset($idAuto)) {

    try {
        $admin = new AdministradorPublicaciones();
        $publicaciones = $admin->damePublicacionesPorAutoYRedSocial($idAuto, $redSocial);
        $idPublicacionSoloAutos;
        $publicacionSoloautos;
        foreach ($publicaciones as $publicacion) {
            $publicacionSoloautos = $publicacion->publicacion;
            $idPublicacionSoloAutos = $publicacion->id;
        }
        $admin->eliminarPublicacion($idPublicacionSoloAutos);
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

        // echo $token;



        $curlDel = curl_init();

        curl_setopt_array($curlDel, array(
            CURLOPT_URL => 'https://inventory.api.carsales.com/v1/vehicles/' . $id_publicacion,
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
        if ($httpcodeDel == 200 || $httpcodeDel == 204) {
            echo json_encode(array("status" => $httpcodeDel, "message" => "Publicacion eliminada correctamente", "idPublicacion" => $idPublicacionSoloAutos));
        } else {
            echo json_encode(array("status" => $httpcodeDel, "message" => "Error al eliminar publicacion", "idPublicacion" => $idPublicacionSoloAutos));
        }
    } catch (Exception $e) {
        echo json_encode("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No se recibieron los parametros necesarios"));
}