<?php

use Slim\Http\StatusCode;

function customCsv($text, $logName = "log"){
    $file = fopen($logName, "a+");
    fwrite($file, date("d/m/Y H:i") .";". $text . "\n");
    fclose($file);
}

function customLog($text, $logName = "log"){
    $file = fopen($logName, "a+");
    fwrite($file, date("d/m/Y H:i") ." - ". $text . "\n");
    fclose($file);
}

function getDiffTime($time){
    $a = new DateTime();
    $b = new DateTime(date("Y-m-d H:i:s", $time));
    return $b->diff($a);
}

function getShippingAddress(array $listAddress){
    $shippAddress = null;

    foreach($listAddress as $item){
        $address = $item->CustomerAddress;

        if($address->type == "1")
            $shippAddress = $address;
    }

    if(empty($shippAddress))
        throw new Exception("Nenhum endereço de entrega disponivel nesse pedido.");

    return $shippAddress;
}

function dateToDB($date){
    if(empty($date))
        return "";

    $saida = "";

    $date = explode(" ", $date);
    
    $data = explode("/", $date[0]);
    $data = $data[2] ."-". $data[1] ."-". $data[0];

    if(isset($date[1])){
        $saida = $data ." ". $date[1];
    }
    else
        $saida = $data;

    return $saida;
}

function dateFromDB($date){
    if(empty($date))
        return "";

    $saida = "";

    $date = explode(" ", $date);
    
    $data = explode("-", $date[0]);
    $data = $data[2] ."/". $data[1] ."/". $data[0];

    if(isset($date[1])){
        $saida = $data ." ". $date[1];
    }
    else
        $saida = $data;

    return $saida;
}

function clearPhoneNumber($number){
    $number = preg_replace("/[^0-9]/", "", $number);
    //$number = substr($number, 2);
    return $number;
}

function clearNameShippiment($str){
    $str = preg_replace("/[^a-zA-Z]/", "", $str);
    $str = str_replace(" - ", "", $str);
    return $str;
}

function searchCotation(string $apiUrl, string $apiUser, string $apiPass, array $cotation) {

    $auth = base64_encode($apiUser.":".$apiPass);

    /********************/
    /* TOKEN PARA A API */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSLVERSION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cotation));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . "Basic ". $auth,
        'Content-Type: application/json'
    ));

    $jsonRetorno = trim(curl_exec($ch));
    $resposta = json_decode($jsonRetorno);
    

    curl_close($ch);
    
    if (isset($resposta->errors)) {
        return false;
    }

    return $resposta;
}

function arrayToXml($array, $xml = null) {
    if ($xml === null) {
        $xml = new SimpleXMLElement('<root/>');
    }

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $child = $xml->addChild($key);
            arrayToXml($value, $child);
        } else {
            $xml->addChild($key, htmlspecialchars($value));
        }
    }

    return $xml->asXML();
}

/**
 * Just for fix jenssegers/laravel-mongodb package issue to using outside of Laravel or Lumen
 */
function app()
{
    return new class
    {
        public function version()
        {
            return '5.4';
        }
    };
}

function curl_get_xml($destino, array $query) {
    $url = $destino . "?" . http_build_query($query);
        
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, false);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = trim(curl_exec($curl));
    curl_close($curl);
    
    return simplexml_load_string($result);
}
