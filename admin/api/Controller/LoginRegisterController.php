<?php

ini_set('display_errors', 0);
error_reporting(0);

include './Helper/mailer.php';

class LoginRegisterController {

    public function login($username, $password, $isweb) {
        $error = '';
        if (strlen($username) < 4) {
            $error .= 'Username cannot be less than 6 characters.';
        }
        if (strlen($password) < 4) {
            $error .= 'Password cannot be less than 6 characters.';
        }
        if (strlen($error) != 0) {
            Helper::sendData(0, $error, 1);
            exit;
        }
        $password = Hash::make($password);
        $loginRegisterModel = new LoginRegisterModel();
        $data = $loginRegisterModel->authenticateUser($username, $password);
        if (mysqli_num_rows($data) == 0) {
            return Helper::getStandardData(0, "Either usernname or password is incorrect", 1);
        } else {
            if ($isweb == "1") {
                $row = mysqli_fetch_assoc($data);
//                var_dump($row);
                if (!isset($_SESSION))
                    session_start();
                $_SESSION['admin_id'] = $row['user_id'];
                $_SESSION['admin_name'] = $row['user_name'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['user_right'] = $row['user_right'];

                $_SESSION['SESSION_TIMEOUT_AFTER'] = 60 * 15;
                $_SESSION['SESSION_VALID_TILL'] = time() + $_SESSION['SESSION_TIMEOUT_AFTER'];

                return Helper::getStandardData(1, "index", 1);
            }else {
                $row = mysqli_fetch_assoc($data);
                return Helper::getStandardData(1, "", 1, $row);
            }
        }
    }

    public function sendResetPasswordLink($isWeb, $username_email) {
        $error = '';

        if (strlen($username_email) == 0) {
            $error .= 'Please Specify Username or Email to Reset Password';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $loginRegisterMOdel = new LoginRegisterModel();
        $validUserRS = $loginRegisterMOdel->isAdminUsernameEmailExist($username_email);

        if (!$validUserRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($validUserRS) == 0) {
            return Helper::getStandardData(0, 'This Credential is not registered with us.', 1);
        } else {
            $row = mysqli_fetch_assoc($validUserRS);
            $adminId = $row['admin_id'];
            $adminName = $row['admin_name'];
            $adminEmail = $row['admin_email'];
            $password = Helper::randomPassword();

            if ($adminEmail == NULL || strlen($adminEmail) == 0) {
                return Helper::getStandardData(0, 'Your Email does not exist.', 1);
            }

            if ($loginRegisterMOdel->updateAdminPassword($adminId, Hash::make($password))) {
                if (sendMail($adminEmail, "CNK4Pets Support", Helper::getPasswordBody($adminName, $password))) {
                    return Helper::getStandardData(1, "We have send you a Password to your email $adminEmail ", 1);
                } else {
                    return Helper::getStandardData(0, "Unable to send Password to your email address.", 1);
                }
            } else {
                return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
            }
        }
    }

}

?>