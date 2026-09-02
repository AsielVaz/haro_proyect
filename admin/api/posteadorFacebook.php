<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/v14.0/107497448690876/feed?message=This%2520is%2520a%2520test%2520activity&og_action_type_id=383634835006146&og_object_id=136050896551329&og_icon_id=609297155780549&access_token=EAAGXb45u4B4BAMlzaIOBCDfUqDluhasmLBP7EaghcRZCJyIVZBWUXx4BUnS21XYVABCToVR4dKi2PJZBB02eOXFHPA0tyekOt3ax0meK7ZBelSUTt8ia04YW8xOZAaeb6OHtWfKeZC67i2oRL9KTWdsqPWxlsSNERh1ZBBtpF8ZAGZAwaCMrDnS7tV7ZB4Ecerl2tpb47cvyhmgiB2AwMiSZCPTC0SywZB66kZCsZD',
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
