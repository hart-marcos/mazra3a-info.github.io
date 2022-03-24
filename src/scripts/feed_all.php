<?php

$type_ = $_GET['type'];

$sr = $_GET["sr"];

$v_ = $_GET["v"];

$uid = isBase64Encoded($_GET["u"]);


if($uid != null && $sr != null && $type_ != null && $v_ != null){

switch ($type_)
{
    case "Gasoline1":
        $type = 't_get_farmclub_final_reward';
        $name = ' بنزين';
    break;
    case "superFertilizer":
        $type = 't_get_mine_woodenChest';
        $name = '  سماد خارق *3 ';
    break;
    case "superkettle":
        $type = 't_get_mine_goldenChest';
        $name = '  دلو خارق';
    break;
    case "fertilizer":
        $type = 't_get_Refinery_gas';
        $name = ' سماد*25';
    break;
    case "OrganicAquaticFertilizer":
        $type = 't_water_ranch_lev';
        $name = '  سماد مائي';
    break;
    case "BingoGoldenBall":
        $type = 't_bingo';
        $name = ' bingo';
    break;
    case "SkyAdventureEnergy_1":
        $type = 't_get_sky_adv_open';
        $name = ' طاقة جوية';
    break;
}


$urls = file_get_contents("../links/". $v_. "/". $type. ".json");

$nbr = 0;

$array = (array)json_decode($urls, true);

$stat = '';

$bool = false;

$cards = count($array);

$cont = 0;

$php = false;

$no_valid = 0;

$break = false;



foreach ($array as $value)
{
    try
    {
        $response = get_web_page($value . '&signed_request=' . $sr);

        if (strpos($response, 'just accepted') || strpos($response, 'Try some new feeds') || strpos($response, 'already accepted this gift'))
        {
            $nbr++;
            $cont++;
        }
        else if ($nbr == 10 || strpos($response, 'daily click limit'))
        {
            $stat = 'limit';
            $cont++;
            break;
        }
        else if (strpos($response, 'try some other posts') || strpos($response, 'Please try some new posts'))
        {
            \array_splice($array, $cont, 1);
            $no_valid++;
            if ($no_valid > 11)
            {
                break;
            }
        }
        else if ($response === '')
        {
            $bool = true;
            break;
        }
        else if(strpos($value, $uid)){
            $cont++;
        }
        else{
            $break = true;
            break;
        }
    }
    catch(Exception $e)
    {
        $php = true;
        break;
    }
}

if ($cards > count($array))
{
    $myfile = fopen("../links/". $v_. "/". $type. ".json", "w") or die("Unable to open file!");

    fwrite($myfile, json_encode($array));
    fclose($myfile);

}

if ($no_valid > 11 || (count($array) < 11 && ($type == 't_bingo' || $type == 't_get_farmclub_final_reward' ) ) || $array = [] || count($array) < 6)
{

    $urls = get_web_page("https://ff-tools.000webhostapp.com/update_urls.php?type=". $type. "&v=". $v_);

    $myfile = fopen("../links/". $v_. "/". $type. ".json", "w") or die("Unable to open file!");
    if(!isJson($urls)){
        $urls='[]';
    }
    fwrite($myfile, $urls);
    fclose($myfile);

    echo 'again (for update)';

}
else
{
    if ($php || $break)
    {

        echo 'again';

    }
    else
    {

        if ($nbr > 0)
        {
            if ($stat === 'limit')
            {
                echo ' تم ارسال '. $nbr.  $name.  ' ووصل الحد ';
            }
            else
            {
                echo ' تم ارسال '. $nbr.  $name. ' وخلصت  روابط '. $name;
            }
        }
        else if ($stat === 'limit')
        {
            echo ' لقد وصلت للحد ';
        }
        else if ($bool)
        {
            echo 'error_sr';
        }
        else
        {
            echo 'agian';
        }

    }

}

}
else{

    echo "parmeters not Ok";

}

function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 30,    // time-out on connect
        CURLOPT_TIMEOUT        => 3,    // time-out on response
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

function isBase64Encoded($str) 
{
    try
    {
        $decoded = base64_decode($str, true);

        if ( base64_encode($decoded) === $str ) {
            return $decoded;
        }
        else {
            return null;
        }
    }
    catch(Exception $e)
    {
        // If exception is caught, then it is not a base64 encoded string
        return null;
    }

}

?>