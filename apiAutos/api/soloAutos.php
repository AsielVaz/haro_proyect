<?php


$client = new GuzzleHttp\Client();

$response = $client->request('POST', 'https://id.s.core.csnglobal.net/connect/token', [
'headers' => [
'Content-Type' => 'application/x-www-form-urlencoded'
],
'form_params' => [
'client_id' => '28c964c8-ac67-4ebf-8b05-70e80b2cfbd4',
'client_secret' => 'CHN9MuGrS8hHq3sev754upGQdPZY57gN',
'grant_type' => 'client_credentials',
]
]);

echo $response->getStatusCode(); // 200
echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
echo $response->getBody(); // '{"Key":"Value", ...}'
var_export($response->json());             // Outputs the JSON decoded data
