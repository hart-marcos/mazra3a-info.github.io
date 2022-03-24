<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);

$myfile = fopen("data/ip_address.txt", "a") or die("Unable to open file!");

date_default_timezone_set("Africa/Algiers");

fwrite($myfile, $ip.  " (". $xml->geoplugin_countryName. ") :  ". date("Y-m-d h:i:sa"). "\n\n---------------------------------------------\n\n");
fclose($myfile);



?>