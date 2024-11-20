<?php

session_start();
require('../../config/database.php');
require('../../config/ipAddress.php');


// FILTER INPUT
function filter_form_input($FInput) {
	$FInput = filter_var($FInput, FILTER_UNSAFE_RAW); 
	$FInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $FInput);
	
	return $FInput;
}

// GET PURPOSE
$purpose = filter_input(INPUT_GET, 'purpose', FILTER_SANITIZE_STRING);

// DELETE MENU ORDER
if($purpose == 'deleteorder') {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $id = base64_decode($id);
    $previous = $_SERVER['HTTP_REFERER'];


	// START PROCESSING
	if($stmt = $con->prepare("DELETE FROM menuorder WHERE id = ?"))
    {	
        $stmt->bind_param( "s", $id );
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!";
			$_SESSION['message'] = "Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Menu Order By Customer Deleted.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} else{

		$_SESSION['result'] = "Failed!";
		$_SESSION['message'] = "Please try again.";
		$_SESSION['icon'] = "error";
        header( "Location: $previous" );
        exit();
		
	}
}
// END DELETE MENU ORDER

// START DELETE PAYMENT
if($purpose == 'deletepayment') {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $id = base64_decode($id);
    $previous = $_SERVER['HTTP_REFERER'];


	// START PROCESSING
	if($stmt = $con->prepare("DELETE FROM payment WHERE id = ?"))
    {	
        $stmt->bind_param( "s", $id );
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!";
			$_SESSION['message'] = "Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Payment Made By Customer Deleted.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} else{

		$_SESSION['result'] = "Failed!";
		$_SESSION['message'] = "Please try again.";
		$_SESSION['icon'] = "error";
        header( "Location: $previous" );
        exit();
		
	}
} 
//END DELETE PAYMENT

else
{
	session_destroy();
    header('Location: ../index.php');
	exit();
}

?>