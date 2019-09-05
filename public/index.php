<?php

require('../vendor/autoload.php');


if(!isset($_GET['icao'])){
    echo "Please supply a airport ICAO";
    die();
}

$airportIcao = $_GET['icao'];

if (!preg_match('/[^A-Za-z]/', $airportIcao) || strlen($airportIcao) != 4) {
    echo "Please supply a valid airport ICAO";
    die();
}


$client = new \GuzzleHttp\Client();


try {
    $response = $client->get("http://metar.vatsim.net/metar.php?id=$airportIcao");
    if ($response->getStatusCode() === 200) {
        $metar = $response->getBody()->getContents();
    }
    if($metar == ""){
        throw new Exception();
    }

} catch (\Exception $e) {
    $response = $client->get("https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&hoursBeforeNow=3&mostRecent=true&stationString=".$airportIcao);

    $xml = new SimpleXMLElement($response->getBody()->getContents());
    if(((int) $xml->data->attributes()->num_results) == 0){
        echo "Invalid ICAO";
        die();
    }
    $metar = (string) $xml->data->METAR->raw_text;
}

$queryString = array_merge($_GET,[
    "metar" => $metar
]);

$response = $client->get("http://uniatis.net/atis.php?".http_build_query($queryString));

echo $response->getBody()->getContents();