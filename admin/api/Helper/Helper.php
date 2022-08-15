<?php

class Helper {

    public static function decrypt_data($var) {
        return base64_decode($var);
    }

    //to ecrypt the data to base 64
    public static function encrypt_data($var) {
        return base64_encode($var);
    }

    public static function sendData($status = 1, $msg, $is_valid_req = 1, $data = array()) {
        if ($status == 0)
            echo Helper::encrypt_data(json_encode(array('status' => 0, 'msg' => $msg, 'is_valid_req' => $is_valid_req)));
        else
            echo Helper::encrypt_data(json_encode(array('status' => 1, 'msg' => $msg, 'data' => $data, 'is_valid_req' => $is_valid_req)));
    }

    public static function getStandardData($status, $msg, $is_valid_req, $data = array()) {
        return Helper::encrypt_data(json_encode(array('status' => $status, 'msg' => $msg, 'data' => $data, 'is_valid_req' => $is_valid_req)));
    }

    public static function Sanitize($data) {
        return htmlentities(trim($data), ENT_QUOTES, 'UTF-8');
    }
    public static function validateProductfile($files) {
        $valid = '';

        $allowedExts = array("pdf", "jpeg", "jpg", "png");
        $checkedExts = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));

        if (($files["size"] > Constant::$MAX_FILE_SIZE)) {
            $valid .= 'File is too Large ';
        }
        if (!in_array($checkedExts, $allowedExts)) {
            $valid .= 'File format is not suppoted';
        }

        return $valid;
    }


    public static function UnSanitize($data) {
        return html_entity_decode(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public static function isValidEmail($email) {
        //write your login here
        return true;
    }

    public static function queryFailedMessage() {
        return "Failed to Query Server. Please try again later";
    }

    public static function uploadFile($files, $targetDir) {
//        $targetDir = Constant::$PRODUCT_IMG_DIR;
        $targetFile = $targetDir . basename($files['name']);

//        //check if file is empty
//        if (!filesize($files)) {
//            return '';
//        }
        // file size
        if ($files['size'] > Constant::$MAX_FILE_SIZE) {
            return '';
        }

        if (!move_uploaded_file($files['tmp_name'], $targetFile)) {
            return '';
        }
        return basename($files['name']);
    }

    public static function validateLogo($files) {


        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $checkedExts = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));

        if (($files["size"] < Constant::$MAX_LOGO_SIZE) && in_array($checkedExts, $allowedExts)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateProductImages($files) {
        $valid = '';

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $checkedExts = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));

        if (($files["size"] > Constant::$MAX_FILE_SIZE)) {
            $valid .= 'File is too Large ';
        }
        if (!in_array($checkedExts, $allowedExts)) {
            $valid .= 'File format is not suppoted';
        }

        return $valid;
    }

    /**
     * To avoid undefined index, first check if index exist or not <br>
     * If index exist in array return arr[index] else an empty string.
     * @param type $arr
     * @param type $index
     * @return type return data if index exist in array, else will return empty string
     */
    public static function getIndex($arr, $index) {
        return isset($arr[$index]) ? $arr[$index] : '';
    }

    public static function getPasswordBody($name, $password) {
        $body = "Hi " . $name . ",<br><br>

Forgot your password? It's okay, we haven't forgotten you! " .
                "<br> Your password is  <strong>" . $password . "</strong><br>
                    You can Update you password in Admin Panel.<br><br>

Regards <br>
Team CNK4Pets<br>
<a href='www.cnk4pets.com'>cnk4pets.com</a>";
        return $body;
    }

    public static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}

?>
