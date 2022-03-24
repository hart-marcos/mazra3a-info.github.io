<?php

$sr = $_POST["sr"];

$valid = isBase64Encoded(explode(".", $sr) [1]);

if ($valid) {
    
    $uid = json_decode(base64_decode(explode(".", $sr) [1]))->{'user_id'};

    $uids = json_decode(file_get_contents("../uids.json"));

    $ban_uids = json_decode(file_get_contents("../ban_uids.json"));



    if (in_array($uid, $uids)) {

        echo "انت مشترك بالفعل :) ...";

    } else if (in_array($uid, $ban_uids)){

         echo " لقد طلبت الغاء الاشتراك من قبل لا يمكنك الاشتراك مرة اخرى ";

    } else if (isJson(file_get_contents(valid_sr($sr,$uid)))) {

        update_srs($sr);

        update_uids($uid,$uids);

        echo "انت لست مشترك . تم الاضافة بنجاح :) .."; 

    } else 
    {
        echo " توجد مشكلة مع ال signed_request الذي ادخلته جرب واحد اخر ...";
    }
}else{

    echo "اعد المحاولة ...";

}


function update_uids($uid,$old){
    
    array_push($old,$uid);

    $myfile = fopen("../uids.json", "w") or die("Unable to open file!");
	
	fwrite($myfile, json_encode($old));

	fclose($myfile);
}

function update_srs($sr){

    $old = json_decode(file_get_contents('../srs.json'));

    array_push($old,$sr);

    $myfile = fopen("../srs.json", "w") or die("Unable to open file!");
	
	fwrite($myfile, json_encode($old));

	fclose($myfile);
}

function valid_sr($sr,$uid){

    $hash = md5($uid . '_');
    $key = vk();
    $link = 'https://farm-us.centurygames.com/ar/facebook/get_feed_key/?type=t_add_collect_jelly_bean&key='. $key. '&hash=-'. $hash. '-&signed_request='. $sr;

    return $link;
}


function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}



function vk(){
 
     $k = '';
     for ($i = 0;$i < 8;$i++)
     {
         $v1 = (1 + mt_rand(0, 10000) / 1000000) * dechex(415030);
         $v2 = floor($v1);
         $v3 = base_convert($v2, 10, 16);
 
         $k .= substr($v3, 1);
 
     }
 
     return $k;
}

function isBase64Encoded($str) {
    
    if (base64_decode($str, true) !== false){
        return true;
    } else {
        return false;
    }
}

?>