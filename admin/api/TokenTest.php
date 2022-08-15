<?php
include './Config/Autoload/autoload.php';
error_reporting(E_ALL);
ini_set("dispaly_errors", 1);
    $arraydata=$_POST['data'];
    if($arraydata['enc']==1)
        echo Hash::generateToken($arraydata);
    else
    {
        print_r( Hash::decryptToken($_POST['token']));
    }
?>