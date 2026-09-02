<?php

include_once("adminAutos.php");
include_once("adminPublicaciones.php");


$adminAutos = new AdministradorAutos();
$adminPublicaciones = new AdministradorPublicaciones();
$auto = $adminAutos->dameAuto($_POST['id_auto']);

function compararSimilares($modelo1, $modelo2)
{
    $modelo1 = str_replace(" ", "", $modelo1);
    $modelo2 = str_replace(" ", "", $modelo2);

    $medidaComparativa = strlen($modelo1);
    if (strlen($modelo2) == 0) {
        return false;
    }

    if (strlen($modelo2) > $medidaComparativa) {
        $medida = $medidaComparativa;
    } else {
        $medida = strlen($modelo2);
    }
    for ($i = 0; $i < $medida; $i++) {
        if ($modelo1[$i] != $modelo2[$i]) {
            //echo  "comparando " . $modelo1 . " con " . $modelo2 . "<br>";
            return false;
        }
    }
    return true;
}

function dameModelos($marca, $modeloM)
{

    $curl = curl_init();


    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://id.s.core.csnglobal.net/connect/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'client_id=28c964c8-ac67-4ebf-8b05-70e80b2cfbd4&client_secret=CHN9MuGrS8hHq3sev754upGQdPZY57gN&grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: csncidcf=2A7E13F1-580F-4ACF-BC36-8EF8E8E71DB3'
        ),
    ));


    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $token = json_decode($response)->access_token;
    echo $token;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://globalinventory-publicapi.stg.core.csnglobal.net/v1/specifications/cl/car/makes/' . $marca . '/models',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Cookie: csncidcf=909C70F9-700F-44E0-B35D-EDE5A746A09F'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $modelos = json_decode($response)->results;
    //todas minusculas
    $modeloM  = strtolower($modeloM);
    //echo $modeloM;
    $select  = "0";
    foreach ($modelos as $modelo) {

        if (compararSimilares($modeloM, strtolower($modelo))) {
            //echo $modelo . " FUE ESTE <br> <br> <br><br>";
            $select =  $modelo;
        }
    }
    return $select;
}

function GUIDv4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        if ($trim === true)
            return trim(com_create_guid(), '{}');
        else
            return com_create_guid();
    }

    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Fallback (PHP 4.2+)
    mt_srand((float)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid,  0,  8) . $hyphen .
        substr($charid,  8,  4) . $hyphen .
        substr($charid, 12,  4) . $hyphen .
        substr($charid, 16,  4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}



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


//echo 'HTTP code: ' . $httpcode;
$guidAuto = GUIDv4();
$cilindrage = $auto->cilindrage;
$descripcion = $auto->descipcion;
$marca = $auto->marca->marca;
$modelo = $auto->modelo->modelo;
$transmicion = $auto->transmision->transmision;
$anio = $auto->anio;
$precio = $auto->precio;
$nacionalidad = $auto->nacionalidad;
$duenio = $auto->duenio;
$estatus = $auto->estatus;
$kilometrage = $auto->kilometrage;
if ($kilometrage = "N/E") {
    $kilometrage = 0;
}
$combustible = $auto->combustible;
$interiores = $auto->interiores->interiores;
$color = $auto->color;
$cuerpo = $auto->cuerpo;
$poder = $auto->poder;
$asientos = $auto->asientos;

if ($combustible = "Gasolina") {
    $combustible = "Gas";
}

if ($combustible = "GASOLINA") {
    $combustible = "Gas";
}

if ($transmicion == "Automática") {
    $transmicion = "Autom\u00e1tica";
}

if ($cuerpo == "") {
    $cuerpo = "Otros";
}



//echo $marca;
//echo $modelo;

$modelo = dameModelos($marca, $modelo);
//echo $modelo . "<br>";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://inventory.api.carsales.com/v1/vehicles/' . $guidAuto,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
        "PublishingDestinations": [
            {
                "Name": "SOLOAUTOS.MX"
            }
        ],
        "Media": {
            "Photos": [
                {
                    "Url": "https://seminuevosharo.mx' . $auto->imagenes[0]->url . '",
                    "Order": "1"
                },
                {
                    "Url": "https://seminuevosharo.mx' . $auto->imagenes[1]->url . '",
                    "Order": "2"
                },
                {
                    "Url": "https://seminuevosharo.mx' . $auto->imagenes[3]->url . '",
                    "Order": "3"
                }
            ]
        },
        "Seller": {
            "Identifier": "65044C3C-7D96-11E9-A279-02A648AAD720"
        },
        "Specification": {
            "RecordType": "Autos, camionetas y 4x4",
            "Make": "' . $marca . '",
            "Model": "' . $modelo . '",
            "ReleaseDate": {
                "Year": ' . $anio . '
            },
            "Title": "' . $anio . ' ' . $marca . ' ' . $modelo . '",
            "ShortTitle": "' . $marca . ' ' . $modelo . '",
            "Attributes": [
                {
                    "Name": "Color",
                    "FeatureGroup": "Detalles",
                    "DisplayName": "Color",
                    "Value": "' . $color . '",
                    "DisplayOnDetailsPage": true,
                    "IsKeyAttribute": false,
                    "IsDeleted": false
                },
                {
                    "Name": "BodyStyle",
                    "FeatureGroup": "Detalles",
                    "Value": "Otros",
                    "DisplayOnDetailsPage": true,
                    "IsKeyAttribute": false,
                    "IsDeleted": false
                },
                {
                    "Name": "FuelType",
                    "FeatureGroup": "Detalles",
                    "Value": "' . $combustible . '",
                    "DisplayOnDetailsPage": true,
                    "IsKeyAttribute": false,
                    "IsDeleted": false
                },
                {
                    "Name": "GearType",
                    "FeatureGroup": "Detalles",
                    "Value": "' . $transmicion . '",
                    "DisplayOnDetailsPage": true,
                    "IsKeyAttribute": false,
                    "IsDeleted": false
                },

                {
                    "Name": "Radio",
                    "FeatureGroup": "Equipamiento",
                    "DisplayName": "Radio",
                    "Value": "SI",
                    "DisplayOnDetailsPage": true,
                    "IsKeyAttribute": false,
                    "IsDeleted": false
                }
            ]
        },
        "Identifier": "' . $guidAuto . '",
        "Type": "Car",
        "ListingType": "Usado",
        "SaleStatus": "In Stock",
       "Registration": {
         "Number": "ABCD12"
        },
        "Description": "",
        "Colours": [
            {
            "Location": "Exterior",
                "Generic": "Grey",
                "Name": "Gris"
            },
            {
            "Location": "Interior",
                "Generic": "Grey",
                "Name": "Gris"
            }
        ],
        "OdometerReadings": [
            {
            "Value":' . $kilometrage . ',
                "UnitOfMeasure": "KM"
            }
        ],
        "PriceList": [
            {
            "Currency": "MXN",
            "Amount": ' . $precio . '
            }
        ]
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
        'Cookie: csncidcf=1B8008AF-4518-4F8E-A15A-F7269A7BE277'
    ),
));

$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);


echo $httpcode;
if ($httpcode == "202") {
    //echo '<br>Auto publicado correctamente';
    $adminPublicaciones->nuevaPublicacion($guidAuto, "soloAutos", date("Y-m-d"), 1, $auto->id);
}
