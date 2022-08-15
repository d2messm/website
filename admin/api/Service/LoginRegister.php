<?php
class LoginRegister{
    public function login($data){
        $username=Helper::Sanitize($data['username']);
        $password=Helper::Sanitize($data['password']);
        $isweb=Helper::Sanitize($data['isweb']);
        $LoginRegisterController=new LoginRegisterController();
        echo $LoginRegisterController->login($username,$password,$isweb);
        exit;
    }
    
    public function sendResetPasswordLink($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $username_email = Helper::Sanitize($data['username_email']);
        
        $LoginRegisterController=new LoginRegisterController();
        echo $LoginRegisterController->sendResetPasswordLink($isWeb, $username_email);
        exit;
    }
}
?>