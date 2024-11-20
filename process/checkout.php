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

    // INVOICE GENERATOR
    function rand_string($len) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $len);
    }

    $purpose = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);

    if($purpose == 'checkout'){
        $amount = filter_input(INPUT_POST, 'totalPrice', FILTER_SANITIZE_STRING);

        $amount = filter_form_input($amount);

        $listmenu = implode(",", $_POST['menuid']); //retrive menuid from menu table (cart.php)
        $date = date("Y-m-d");
        $orderid = "IQP".date("dm").rand_string(4);
        // $description = "Payment For " . $invoice;

        $sql = "INSERT INTO menuorder (order_ID,listmenu,amount, date) VALUES ( ?, ?, ?, ? )";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $orderid, $listmenu, $amount, $date );

        if(!mysqli_stmt_execute($stmt)) {

            $_SESSION['result'] = "Failed!";
            $_SESSION['message'] = "Please try again.";
            $_SESSION['icon'] = "error";
            header( "Location: ../cart.php" );
            exit();
        
        }
        else{

            header( "Location: ../checkout.php?id=$orderid" );
            exit();
        }
    }
    else {

        session_destroy();
        header('Location: ../index.php');
        exit();
    
    }

?>