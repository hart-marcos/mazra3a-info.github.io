<?php
$sr = $_GET["sr"];

$urls = file_get_contents("links/t_get_farmclub_final_reward.json");

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
        $response = file_get_contents($value . '&signed_request=' . $sr);

        if (strpos($response, 'يساعد') || strpos($response, 'بذور الجديدة'))
        {
            $nbr++;
            $cont++;
        }
        else if ($nbr == 10 || strpos($response, 'لقد وصلت'))
        {
            $stat = 'limit';
            $cont++;
            break;
        }
        else if (strpos($response, 'عفوا عزيزي المزارع'))
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
        else
        {
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

    $myfile = fopen("links/t_get_farmclub_final_reward.json", "w") or die("Unable to open file!");

    fwrite($myfile, json_encode($array));
    fclose($myfile);

}

if (($no_valid > 11 || count($array) < 11) || $array = [])
{

    $urls = file_get_contents('https://ff-tools.000webhostapp.com/update_urls.php');

    $myfile = fopen("links/t_get_farmclub_final_reward.json", "w") or die("Unable to open file!");

    fwrite($myfile, $urls);
    fclose($myfile);

    echo '<script> top.location.href = "test_feed_gaz.php?sr="' . $sr . ';   </script>';

}
else
{

    if ($php || $break)
    {

        echo '<script> alert("  2 اعد المحاولة"); top.location.href = "feed_gaz.html";   </script>';

    }
    else
    {

        if ($nbr > 0)
        {
            if ($stat === 'limit')
            {
                echo '<script> alert(" تم ارسال' . $nbr . ' بنزين ووصل الحد "); top.location.href = "feed_gaz.html";   </script>';
            }
            else
            {
                echo '<script> alert(" تم ارسال' . $nbr . ' بنزين وخلص البنزين"); top.location.href = "feed_gaz.html";   </script>';
            }
        }
        else if ($stat === 'limit')
        {
            echo '<script> alert(" لقد وصلت للحد "); top.location.href = "feed_gaz.html";   </script>';
        }
        else if ($bool)
        {
            echo '<script> alert(" ال signed_request خطأ "); top.location.href = "feed_gaz.html";   </script>';
        }
        else
        {
            echo '<script> top.location.href = "test_feed_gaz.php?sr="' . $sr . ';   </script>';
        }

    }

}

?>