<?php

class Hash {

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length) {
        return mcrypt_create_iv($length);
    }

    public static function unique() {
        return Self::make(uniqid());
    }

    public static function generateToken($arrayData) {
        $arrayData['validity'] = time() + Constant::$SESSION_TIME_EXTEND;
        $newToken = Hash::encryptToken($arrayData);
        return $newToken;
    }

    public static function decryptToken($tokenData) {
        $aes = new AESEncryptionDecryption($tokenData, Constant::$INPUT_KEY, Constant::$BLOCKSIZE);
        $resultStr = json_decode($aes->decrypt());
        return $resultStr;
    }

    public static function encryptToken($arrayData) {
        $aes = new AESEncryptionDecryption(json_encode($arrayData), Constant::$INPUT_KEY, Constant::$BLOCKSIZE);
        $newToken = $aes->encrypt();
        return $newToken;
    }

}
