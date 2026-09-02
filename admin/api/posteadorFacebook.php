<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'env.php';

$facebookAccessToken = haroEnv('FACEBOOK_ACCESS_TOKEN');
$facebookUrl = 'https://graph.facebook.com/v14.0/107497448690876/feed'
    . '?message=This%2520is%2520a%2520test%2520activity'
    . '&og_action_type_id=383634835006146'
    . '&og_object_id=136050896551329'
    . '&og_icon_id=609297155780549'
    . '&access_token=' . rawurlencode($facebookAccessToken);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $facebookUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
