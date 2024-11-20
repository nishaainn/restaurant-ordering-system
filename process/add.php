<?php

	session_start();
	require('../config/database.php');
    require('../config/ipAddress.php');

	
	// FILTER INPUT
	function filter_form_input($FInput) {
		$FInput = filter_var($FInput, FILTER_UNSAFE_RAW); 
		$FInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $FInput);
		
		return $FInput;
	}
	
	
$purpose = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);
$previous = $_SERVER['HTTP_REFERER'];

// CONTACT
if($purpose == 'contactus') {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $msgid = filter_input(INPUT_POST, 'msgid', FILTER_SANITIZE_STRING);


	$name = filter_form_input($name);
    $email = filter_form_input($email);
    $subject = filter_form_input($subject);
    $message = filter_form_input($message);
    $msgid = filter_form_input($msgid);
    

	$sql = "INSERT INTO contact ( name,email,subject,message,msg_id) VALUES (?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $subject ,$message,$msgid);
    
    if(!mysqli_stmt_execute($stmt)) {

        $_SESSION['result'] = "Failed!";
        $_SESSION['message'] = "Please try again.";
        $_SESSION['icon'] = "error";
        header( "Location: ../index.php" );
        exit();
    
    }
	else{
		$_SESSION['result'] = "Success!";
        $_SESSION['message'] = "Your messages have been send.";
        $_SESSION['icon'] = "success";
        header( "Location: ../contact.php" );
        exit();
	}
}
//END CONTACT


//START ORDER
if($purpose == 'addtocart') {

    $menuid = filter_input(INPUT_POST, 'menuid', FILTER_SANITIZE_STRING);
    $qty = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_STRING);

    $qty = filter_form_input($qty);

    $stmt = $con-> prepare ("SELECT quantity FROM cart WHERE ipAddress = ? AND menuid = ?");
    $errorchecking = $stmt->bind_param("ss",$ip_address,$menuid);
    $errorchecking = $stmt->execute();
    $stmt->bind_result($qty2);
    $stmt->store_result();
    $val = $stmt->num_rows;
    while($stmt->fetch()){
        $qty2 = $qty2;
    }

    if($val > 0){
    
        $qty = $qty + $qty2;

        if($stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE menuid = ? AND ipAddress = ?"))
        {
            $stmt->bind_param("sss",$qty,$menuid,$ip_address);

            if(!mysqli_stmt_execute($stmt)) {

                $_SESSION['result'] = "Failed!";
                $_SESSION['message'] = "Sorry your order do not being saved.";
                $_SESSION['icon'] = "error";
                header( "Location: $previous" );
                exit();
            
            }
            else{
                $_SESSION['result'] = "Success!";
                $_SESSION['message'] = "Your order have been send.";
                $_SESSION['icon'] = "success";
                header( "Location: $previous" );
                exit();
            }
        }
        else{
            $_SESSION['result'] = "Failed!";
            $_SESSION['message'] = "Sorry your order do not being saved.";
            $_SESSION['icon'] = "error";
            header( "Location: $previous" );
            exit();
        }
    }
    else{

        $sql = "INSERT INTO cart ( menuid,ipAddress,quantity) VALUES (?,?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $menuid, $ip_address, $qty );

        if(!mysqli_stmt_execute($stmt)) {

            $_SESSION['result'] = "Failed!";
            $_SESSION['message'] = "Sorry your order do not being saved.";
            $_SESSION['icon'] = "error";
            header( "Location: $previous" );
            exit();
        
        }
        else{
            $_SESSION['result'] = "Success!";
            $_SESSION['message'] = "Your order have been send.";
            $_SESSION['icon'] = "success";
            header( "Location: $previous" );
            exit();
        }
    }
}

else {

	session_destroy();
	header('Location: ../index.php');
	exit();
}


?>