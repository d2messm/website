<?php
//display error like in localhost
/* error_reporting(E_ALL);
ini_set('display_errors', 1);*/

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
// require 'vendor/autoload.php';

require '../assets/phpmailer/src/PHPMailer.php';
require '../assets/phpmailer/src/Exception.php';
require '../assets/phpmailer/src/SMTP.php';


function sendMail($to, $subject, $body, $username='contact@cnk4pets.com', $password='cnk4pets', $from='contact@cnk4pets.com', $from_name='CNK4Pets Support', $replyto='contact@cnk4pets.com', $replyto_name='CNK4Pets Support' ) {

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions    
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
//    	$mail->Host = 'secure189.servconfig.com';   // Specify main and backup SMTP servers
    	$mail->Host = 'cnk4pets.com;secure189.servconfig.com';   // Specify main and backup SMTP servers
    	
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
    	
    	$mail->Username = $username;
    	$mail->Password = $password;
    	
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = 587;                                    // TCP port to connect to
        $mail->Port = 465;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom($from, $from_name);
        // $mail->addAddress('mynameisakashkumar@gmail.com', 'Akash Kumar');     // Add a recipient
        $mail->addAddress($to);               // Name is optional $mail->addAddress('email', 'name');
    	
        $mail->addReplyTo($replyto, $replyto_name);
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
    // 	$mail->addAttachment('download.png', 'dummy_image.png');
    	
        $mail->AltBody = strip_tags($mail->Body);   // in case if the client does not support html
    
        $mail->send();
//         echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
//        echo 'Message could not be sent.';
//        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    }
}
?>