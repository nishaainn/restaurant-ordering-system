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

// GET PURPOSE
$purpose = filter_input(INPUT_GET, 'purpose', FILTER_SANITIZE_STRING);
$previous = $_SERVER['HTTP_REFERER'];

// DELETE CART
if($purpose == 'deleteCart') {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $id = base64_decode($id);

	// START PROCESSING
	if($stmt = $con->prepare("DELETE FROM cart WHERE id = ?"))
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
			$_SESSION['message'] = "Cart Deleted.";
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
// END DELETE CART

else
{
	session_destroy();
    header('Location: ../index.php');
	exit();
}

?>