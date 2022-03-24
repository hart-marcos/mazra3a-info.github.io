<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$uid = $_GET["u"];

$v_ = $_GET["v"];

$u = "no_id";

if(is_base64($uid)){
    $u = base64_decode($uid);
}

if($v_ == "us" || "fr" || "th"){

    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);

    $t = date("Y-m-d h:i:sa");

    $old_ = file_get_contents("data/". $v_. "/feeds_uids.json");

    $data = json_decode($old_);

    if(isset($data ->$u)){
        if(!isset($data ->$u ->times ->$t)){

            $obj = '{"contry": "'. $xml->geoplugin_countryName. '", "ip_address": "'. $ip. '"}';

            $obj_ = json_decode($obj);

        	$data ->$u ->times ->{$t} = $obj_;
        }
    }else{
    
        $obj = '{ "times": { "'. $t. '": {"contry": "'. $xml->geoplugin_countryName. '", "ip_address": "'. $ip. '"}}}';

        $obj_ = json_decode($obj);

        $data ->{$u} = $obj_;

    }


    $myfile = fopen("data/". $v_. "/feeds_uids.json", "w") or die("Unable to open file!");

    date_default_timezone_set("Africa/Algiers");

    fwrite($myfile, json_encode($data));
    fclose($myfile);

}



function is_base64($s){
    // Check if there are valid base64 characters
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

    // Decode the string in strict mode and check the results
    $decoded = base64_decode($s, true);
    if(false === $decoded) return false;

    // Encode the string again
    if(base64_encode($decoded) != $s) return false;

    return true;
}

?>