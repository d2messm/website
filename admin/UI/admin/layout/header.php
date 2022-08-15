<?php
include_once '../../api/Config/Autoload/autoload.php';
if (!isset($_SESSION))
    session_start();
define("REDIRECT_LOC", "../login.php");
if ((!isset($_SESSION) || !isset($_SESSION['admin_id']) || !isset($_SESSION['SESSION_TIMEOUT_AFTER']))) {
   // header("Location:../login.php");
    exit;
}
if ($_SESSION['SESSION_VALID_TILL'] < time()) {
    echo '<script>confirm("Kindly login again to continue");window.location.href="' . REDIRECT_LOC . '"</script>';
    exit;
} else {
    $_SESSION['SESSION_VALID_TILL'] += $_SESSION['SESSION_TIMEOUT_AFTER'];
}
echo "<script>var aid=" . $_SESSION['admin_id'] . "</script>";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CNK4PETS | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!--responsive.dataTables.min-->
        <link rel="stylesheet" href="dist/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="dist/css/jquery.dataTables.min.css">

        <!-- This style will hide input type number up and down arrow -->
        <style>
            input,textarea{width:100%; font-family:inherit;font-size:inherit;line-height:inherit;}
            select{width:100%; font-family:inherit;font-size:inherit;line-height:inherit}
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                /* display: none; <- Crashes Chrome on hover */
                -webkit-appearance: none;
                margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">