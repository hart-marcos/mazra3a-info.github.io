<?php

$sr = $_GET["sr"];

$urls = file_get_contents('urls.json');

$nbr = 0;

$array = json_decode($urls, true)['urls'];

$stat = '';

$bool = false;

$cards = count($array);

$cont = 0;

$php = false;

foreach ($array as $value) {

try {
     $response = file_get_contents($value. '&signed_request='. $sr);

    if(strpos($response,'يساعد') || strpos($response,'بذور الجديدة') ){
        $nbr++;
        $cont++;
    }else if($nbr == 10 || strpos($response,'لقد وصلت')){
        $stat = 'limit';
        $cont++;
        break;
    }else if(strpos($response,'عفوا عزيزي المزارع')){
       \array_splice($array, $cont, 1);
    }else if($response === ''){
        $bool = true;
        break;
    }
}
catch (Exception $e) {
    $php = true;
    break;
}



}

if($cards > count($array)){
    
    $myfile = fopen("urls.json","w") or die("Unable to open file!");

   fwrite($myfile,'{"urls":'. json_encode($array). '}');
   fclose($myfile);


}


if($php){

echo '<script> alert(" حدث خطأ اعد المحاولة"); top.location.href = "feed_gaz.html";   </script>';

}else{

if($nbr>0){
if($stat === 'limit'){
    echo '<script> alert(" تم ارسال'. $nbr. ' بنزين ووصل الحد "); top.location.href = "feed_gaz.html";   </script>';
}else{
    echo '<script> alert(" تم ارسال'. $nbr. ' بنزين وخلص البنزين"); top.location.href = "feed_gaz.html";   </script>';
}
}else if($stat === 'limit'){
   echo '<script> alert(" لقد وصلت للحد "); top.location.href = "feed_gaz.html";   </script>'; 
}else if($bool){
   echo '<script> alert(" ال signed_request خطأ "); top.location.href = "feed_gaz.html";   </script>';  
}else{
  echo '<script> alert(" خلص البنزين  "); top.location.href = "feed_gaz.html";   </script>';  
}

}



?>