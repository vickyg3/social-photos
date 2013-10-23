<?php
function http_get($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function http_post($url, $data, $image_upload = false, $xml_post = false)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    if($xml_post)
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/atom+xml'));
    if($image_upload)
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: image/jpeg'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function http_put($url, $body)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

?>
