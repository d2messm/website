<?php

class LoginRegisterModel extends Database {

    public function authenticateUser($username, $password) {
        $sql = "select * from user_login where user_name='$username' and user_password='$password';";
        return parent::executeQuery($sql);
    }

    public function authenticateUserByAdminId($adminId, $password) {
        $sql = "select * from user_login where `user_id`='$adminId' and user_password='$password';";
        return parent::executeQuery($sql);
    }

    public function isAdminUsernameEmailExist($username_email) {
        $sql = "SELECT * FROM `admin` WHERE `username`='$username_email' OR `admin_email`='$username_email'";
        return parent::executeQuery($sql);
    }

    public function updateAdminPassword($adminId, $password) {
        $sql = "UPDATE `admin` SET `password`='$password' WHERE `admin_id`='$adminId'";
        return parent::executeQuery($sql);
    }

}

?>
