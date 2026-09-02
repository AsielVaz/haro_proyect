<?php
	require_once "vendor/autoload.php";
     use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Pool;
    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\Response;

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
