<?php


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v17.0/187052137814295/messages',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'
{
  "messaging_product": "whatsapp",
  "to": "52'.$_POST['telefono'].'",
  "type": "template",
  "template": {
    "name": "n_corrida",
    "language": {
      "code": "es"
    },
    "components": [
        {
        "type": "button",
        "sub_type": "url",
        "index": 0,
        "parameters": [
          {
            "type": "text",
            "text": "?pp='.$_POST['url'].'"
          }
        ]
      }
    ]
  }
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer EABraG1mmqU0BOZC8i15L0OwPgtNGpagYtrx86JH5LdZC9y1SREr0VJbkj1ZAmkEZBhfwmuVXwQ7rd2jTMfpSjv0Yi7RURgWP0GZAM8LEi7nMb04ZAsBZAsoPFYQHygsvEZCoLprd598xYgRPnDXMifLpjMHm15xyz9QRUZC1jpgtIOsn6hd2vN1D1z2CHMRTEHQ0ubrKwfaffFpfEJlSZB',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
