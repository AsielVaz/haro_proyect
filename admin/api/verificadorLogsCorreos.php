<?php
include_once 'conectorBD.php';
$conector = new Conector();
$hoy = date("Y-m-d");
$query = "SELECT 
    auto.id, 
    COUNT(log_envio_correo.id) AS total_envios
FROM auto
LEFT JOIN log_envio_correo 
    ON log_envio_correo.id_auto = auto.id
WHERE auto.notificado = 1 and auto.fecha_cap BETWEEN '$hoy 00:00:00' AND '$hoy 23:59:59'
GROUP BY auto.id;";

$result = $conector->ejecutar($query);

//recorrer los resultados y mostrar el total de envíos por auto
while ($row = mysqli_fetch_assoc($result)) {
    $id_auto = $row['id'];
    $total_envios = $row['total_envios'];
    echo "Auto ID: $id_auto - Total de envíos: $total_envios <br>";
    if ($total_envios == 0) {
        echo "El correo no se mando para el auto $id_auto <br>";
        enviarMensajeTelegram($id_auto);
    }
    sleep(1); // Pausa de 1 segundo entre cada mensaje
}



function enviarMensajeTelegram($id_auto)
{

    $token = '8616291163:AAFhetYEVCujsDBCu8nUnjDRQavjMCMdwc4';
    $chatId = '7410099219';

    $mensaje = '<b>El correo no se mando</b>' . "\n";
    $mensaje .= "Pero el auto $id_auto ya aparece como notificado." . "\n";

    $url = "https://api.telegram.org/bot{$token}/sendMessage";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'chat_id' => $chatId,
        'text' => $mensaje,
        'parse_mode' => 'HTML'
    ));

    $respuesta = curl_exec($ch);
    curl_close($ch);

    echo $respuesta;
}
