<?php

$type = $_GET["type"] ?? null;
$txt = $_GET["sr"];
$uid = $_GET["uid"];
$v = $_GET["v"];

switch ($v)
{
    case "us":
        $url = 'https://farm-us.centurygames.com/am/facebook/getCoins/';
    break;
    case "th":
        $url = 'https://farm-th.centurygames.com/en/facebook/getCoins/';
    break;
    case "fr":
        $url = 'https://farm-fr.centurygames.com/en/facebook/getCoins/';
    break;
}




if($type !== null && $type !== "" && $url != null){

 $x = 0;
 $s = round(microtime(true));
 $cmd_list=array($s,$url);
while($x <= 701) {
    array_push($cmd_list,md5($x. $type. $s));
    $x++;
}

echo json_encode($cmd_list);

}else{
    echo "{error:'yes'}";
}




?>