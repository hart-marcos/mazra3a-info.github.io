<?php
$sr = "N1W-sr1-pA8OeGy4bthMB9d7mKp6BKJdTvJR4ug4LcQ.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImV4cGlyZXMiOjE2MzQ3NDIwMDAsImlzc3VlZF9hdCI6MTYzNDczNjY3OSwib2F1dGhfdG9rZW4iOiJFQUFDZWlKVE8yc3NCQUlyMDdyYkJQNWJLeExXWWRJclBtTlBGc3ZCTHlQaU96RXloMGFmeERndjl1MFM5N2lTdDRsWkMycmtqbmpTcjRLR2ZkMUVUWkIxVjM4ZzEwSnF6M1FydUUxdnNZVVV2TkJUTFBPWDFrVjEzUVJYcDFvR0dUR2hVdlFMdHZDUWtPOFloVEhqcEpXZThIaWdYMFM5WEd6dklqMWR4alhva3ptQjljbFk2d0ZkQXFkekxYdTZEUGdUaHVaQTdBWkRaRCIsInRva2VuX2Zvcl9idXNpbmVzcyI6IkFiemo2blByUTBLOVlVb0wiLCJ1c2VyX2lkIjoiMTEzNjgxMzIwOTczODcxIn0";

$uid = "113681320973871";

echo " -> ". valid_sr($sr,$uid);

function valid_sr($sr,$uid){

    $hash = md5($uid . '_');
    $key = vk();
    $link = "https://farm-us.funplusgame.com/ar/facebook/get_feed_key/?type=t_add_collect_jelly_bean&key=". $key. "&hash=-". $hash. "-&signed_request=". $sr;
    $res = file_get_contents($link);

    return $res;
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

?>