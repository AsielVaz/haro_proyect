<?php
require_once "vendor/autoload.php";

use GuzzleHttpClient;

$client = new GuzzleHttp\Client();


$response = $client->request('POST', 'http://globalinventory-publicapi.stg.core.csnglobal.net/v1/vehicles/SA-SELLER-4975', [
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IkIxNUYwQUQzQTc3NzQzRTY3RDU5NkFGNzVENjYwODRFOEM3NThCMEYiLCJ0eXAiOiJKV1QiLCJ4NXQiOiJzVjhLMDZkM1EtWjlXV3IzWFdZSVRveDFpdzgifQ.eyJuYmYiOjE2NTYzNDY4MzksImV4cCI6MTY1NjM1MDQzOSwiaXNzIjoiaHR0cHM6Ly9pZC5zLmNvcmUuY3NuZ2xvYmFsLm5ldCIsImF1ZCI6Imh0dHBzOi8vaWQucy5jb3JlLmNzbmdsb2JhbC5uZXQvcmVzb3VyY2VzIiwiY2xpZW50X2lkIjoiMjhjOTY0YzgtYWM2Ny00ZWJmLThiMDUtNzBlODBiMmNmYmQ0IiwiY2xpZW50X0NsYWltcyI6IkludmVudG9yeSBTdWJtaXNzaW9uIn0.3eRYPHjLt1hEu40LYq1CXHCGTgxoGtoG4O328K0pWq7ozv_7wFKB0iK4YNOe45Rq3KFIuN9sn9mjnyKr_rb8yYRIeSCkdGXSM5tSAf86H1FMdTYy31qWKOVxvlmUHlc_mws_LvrAhozUSW_Mi9gD9KEJ1f4LYDXof8J1ngvByTOxgRaRfxYgjwADApUHa7h8bzuP2pmRwgZ_3feq7qBXhVU8fnwXyc2BYxqmuYX9Dbhjjt7JaGaE1cvVY9tXKP8pGYCmrBEPow-Dt78BSTa_0gQNyiqi5HhJw43RB9IC5OXQ2a-TyS8z1OFLxbVfZXmTIxvFG-Lo_ssmWWTlos4QPw'
    ],
    'body' => [
        'Identifier' => '6C705713-52E6-447B-9FC2-C3C155EF41D0',
        'Type' => 'CAR',
        'ListingType' => 'USADO',
        'SaleStatus' => 'In Stock',
        'Description' => 'This is just a comment'

    ]
]);

echo $response->getStatusCode(); // 200
echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
echo $response->getBody(); // '{"Key":"Value", ...}'
var_export($response->json());             // Outputs the JSON decoded data