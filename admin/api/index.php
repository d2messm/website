<?php

include './Config/Autoload/autoload.php';
if (Constant::$IS_ERROR_ON == 1) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

if (!isset($_POST['sname']) || !isset($_POST['fname']) || !isset($_POST['tval'])) {
    Helper::sendData(0, "Invalid Request 1", 0);
    exit;
} else if ($_POST['isweb'] == "1" && !isset($_POST['from_website'])) {
    //from website(=1) -> if request is comming from website front end
    $urlhit = explode('/', $_SERVER['HTTP_REFERER']);
    if (end($urlhit) != Constant::$LOGIN_PAGE) {
        // in order to validate user other than login.php we have to start the session
        // so we can acces session varialble like admin_id etc is set or not
        if (!isset($_SESSION))
            session_start();

        if (!isset($_SESSION) || !isset($_SESSION['admin_id']) || !isset($_SESSION['SESSION_TIMEOUT_AFTER'])) {
            Helper::sendData(0, "Invalid Request 3", 0);
            exit;
        }

        if ($_SESSION['SESSION_VALID_TILL'] < time()) {
            Helper::sendData(0, "Invalid Request 2", 0);
            exit;
        } else {
            $_SESSION['SESSION_VALID_TILL'] += $_SESSION['SESSION_TIMEOUT_AFTER'];
        }
    }
}

$servicename = Helper::Sanitize($_POST['sname']);
$methodName = Helper::Sanitize($_POST['fname']);
$data = $_POST;
$files = $_FILES;
$tval = Helper::Sanitize($_POST['tval']);
Index::GetApiData($servicename, $methodName, $data, $files);
exit;

class Index {

    public static function GetApiData($servicename, $methodName, $data = '', $files = '') {
        $serviceDao = new $servicename;
        if (method_exists($serviceDao, $methodName)) :
            if ($files != '')
                $serviceDao->$methodName($data, $files);
            else
                $serviceDao->$methodName($data);
        else:
            Helper::sendData(0, "Call to unknown method", 1);
        endif;
    }

}
