<?php
include_once './layout/header.php';
include_once './layout/mainnav.php';
include_once './layout/sidemenu.php';
?>
<style>


    .load {
        border: 14px solid #f3f3f3;
        border-radius: 50%;
        border-top: 14px solid #3498db;
        width: 80px;
        height: 80px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
<div class="load" id="loader" style="position:absolute;top:25%;left:50%;z-index: 999;display: none;"></div>
<?php

if (isset($_GET['page_name'])) {
    echo '<script>var lid=' . $_GET['lid'] . ';</script>';
    include_once './pages/' . $_GET['page_name'] . '.php';
} else {
    echo '<script>var lid=0;</script>';
    include_once './pages/dashboard.php';
}
include_once './layout/footer.php';
?>

