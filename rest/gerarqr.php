<?php
$api = (isset($_POST['api'])) ? $_POST['api'] : '';
$token = (isset($_POST['token'])) ? $_POST['token'] : '';
$chave = (isset($_POST['chave'])) ? $_POST['chave'] : '';
$ip = (isset($_POST['ipoudominio'])) ? $_POST['ipoudominio'] : '';
$porta = (isset($_POST['porta'])) ? $_POST['porta'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$curl = curl_init();


if ($porta == 443){
    $conectar = 'https://'.$ip;
}else{
    $conectar = 'http://'.$ip.':'.$porta.'';
}

echo "<pre>";

curl_setopt_array($curl, array(
    CURLOPT_URL => $conectar.'/api/'.$api.'/start-session',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "webhook": null,
    "waitQrCode":false
}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$token
    ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$obj = json_decode($response);
echo $response.'<br>';
echo $token.'<br>';

