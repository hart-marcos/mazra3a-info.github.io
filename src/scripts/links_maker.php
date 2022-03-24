<?php

$uid = $_GET["u"];

if(is_base64($uid)){

    $u = base64_decode($uid);

    $v = $_GET["v"];

    $url = 'https://farm-'. $v. '.centurygames.com/facebook/get_feed_key/';

    $hash = md5($u. '_');

    $url_64 = base64_encode($url);

    $cmd_list=array($hash,$url_64);

    echo json_encode($cmd_list);
    
}else{

 echo json_encode(["what do","you want ?"]);

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