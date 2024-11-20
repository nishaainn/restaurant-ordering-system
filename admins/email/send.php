<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];

    // SEND EMAIL
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->SMTPDebug = 1;
    $mail->Host = 'mail.nishaainn.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'TLS';
    $mail->SMTPAuth = true;
    $mail->SMTPOptions = array(
        'TLS' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->IsHTML(true);
    $mail->Username = 'admin@nishaainn.com';
    $mail->Password = 'Nisha@123'; //Password domain email = Nisha@123
    $mail->setFrom('admin@nishaainn.com', 'Qrispy Pizza');
    $mail->addAddress($email, $name);
    $mail->Subject = 'Email Testing';
    $mail->Body = "
        <p>Hello,</p><p style='margin-bottom: 30px;'>Sir/Madam, $name</p><p style='margin-bottom: 10px;'>You recently requested to reset the password for your [admins] account. Your new password: <span style='color: #4db3df;'>nisha2002</span></p>
		<p style='margin-bottom: 30px;'><a href='https://restaurant.nishaainn.com/admins' style='color: #4db3df;'>Click Here To Proceed. Thank you.</a></p><p>Do not share this email to the others.</p><hr><small>If you did not request a password reset, please ignore this email.This is a auto-generated email, please do not reply to this email.</small>
        ";//keluarkan password string
    $mail->AltBody = 'HTML messaging is not supported';

    if($mail->send()){
        echo 'success';
    } else {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>