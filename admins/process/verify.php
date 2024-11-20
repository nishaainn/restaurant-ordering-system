<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require('../../config/database.php');

// FILTER INPUT
function filter_form_input($FInput) {
	$FInput = filter_var($FInput, FILTER_UNSAFE_RAW); 
	$FInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $FInput);
	
	return $FInput;
}

// PASSWORD GENERATOR
function rand_string($len) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $len);
}

// GET PURPOSE
$purpose = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);

// VERIFY EMAIL
if($purpose == 'forgotpassword') {
	
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$email = filter_form_input($email);

    // OTHER
    $status = 'active';
	$new_pass = rand_string(15);
	$hash = password_hash($new_pass, PASSWORD_DEFAULT);
	
    // CHECK EXISTENCE
    $stmt = $con->prepare("SELECT first_name FROM user WHERE email = ? AND status = ?");
    $errorchecking = $stmt->bind_param("ss", $email, $status);
    $errorchecking = $stmt->execute();
    $stmt -> bind_result( $name );
    $stmt->store_result();
    $val = $stmt->num_rows;
    while ($stmt->fetch()){ $name = $name; }

   

	if($val > 0) {

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
            <p>Hello,</p><p style='margin-bottom: 30px;'>Sir/Madam, $name</p><p style='margin-bottom: 10px;'>Your new password:$new_pass <span style='color: #4db3df;'><b>$pass</span></p>
            <p style='margin-bottom: 30px;'><a href='https://restaurant.nishaainn.com/admins' style='color: #4db3df;'>Please Click here to sign in. Thank you.</a></p><p>Do not share this email to the others.</p><hr><small>This is a auto-generated email, please do not reply to this email.</small>
            ";//keluarkan password string
        $mail->AltBody = 'HTML messaging is not supported';

        if($mail->send()){

            $stmt = $con->prepare("UPDATE user SET password = ? WHERE email = ?");
            $stmt->bind_param( "ss", $hash, $email );
            $stmt->execute();

            $_SESSION['result'] =  "Your new password updated, please check your email.";
            $_SESSION['message'] = "You can change your password in setting.";
            $_SESSION['icon'] =  "success";
            header( "Location: ../forgotpassword.php" );
            exit();
    
        } else {
            $_SESSION['result'] =  "Failed.";
            $_SESSION['message'] = "Please try again.";
            $_SESSION['icon'] =  "error";
            header( "Location: ../forgotpassword.php" );
            exit();

        }
	} else {

		$_SESSION['result'] =  "email does not exist";
        $_SESSION['message'] = "Please try again.";
        $_SESSION['icon'] =  "error";
		header( "Location: ../forgotpassword.php" );
		exit();

	}
}
// END VERIFY EMAIL

else
{
	session_destroy();
    header('Location: ../index.php');
	exit();
}

?>