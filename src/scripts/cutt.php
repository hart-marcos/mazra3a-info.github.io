<?php

$link = $_GET["link"];

$destination = "https://cutt.ly/scripts/shortenUrl.php";

$eol = "\r\n";
$data = '';

$mime_boundary=md5(time());

$data .= '--' . $mime_boundary . $eol;
$data .= 'Content-Disposition: form-data; name="url"' . $eol . $eol;
$data .= $link . $eol;
$data .= '--' . $mime_boundary . $eol;
$data .= 'Content-Disposition: form-data; name="domain"; ' . $eol;
$data .= "0" . $eol;
$data .= "--" . $mime_boundary . "--" . $eol . $eol; // finish with two eol's!!

$params = array('http' => array(
                  'method' => 'POST',
                  'header' => 'Content-Type: multipart/form-data; boundary=' . $mime_boundary . $eol,
                  'content' => $data
               ));

$ctx = stream_context_create($params);
$response = file_get_contents($destination, FILE_TEXT, $ctx);

echo $response;

?>