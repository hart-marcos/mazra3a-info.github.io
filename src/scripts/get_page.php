<?php

$id = $_GET['id'];

if($id){

    
try {
    echo file_get_contents("../pages/". $id. ".txt");
}
catch (Exception $e) {
    echo ":'(";
}

}

?>