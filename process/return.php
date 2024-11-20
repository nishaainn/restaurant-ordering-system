<?php 

session_start();
require('../config/database.php');

// PAGE NOT FOUND
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("location: ../404.php");
}

// PAGE FOUNDED
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $PaymentID = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_STRING);
    $TxnStatus = filter_input(INPUT_GET, 'status_id', FILTER_SANITIZE_STRING);
    $TxnMessage = filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING);
    $TxnID = filter_input(INPUT_GET, 'transaction_id', FILTER_SANITIZE_STRING);
    $HashValue = filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_STRING);
}

// SENANGPAY
$serviceid = "492167047301942";
$pass = "5172-96395350";
$tobehash = $pass.$TxnStatus.$PaymentID.$TxnID.$TxnMessage;
$haskey = hash_hmac('sha256', $tobehash, $pass);

// OTHERS
$date = date('Y-m-d');

if($HashValue == $haskey) {
	
	// CANCEL
    if($TxnStatus == '0'){

        $status = 'failed';

        $stmt = $con->prepare("UPDATE payment SET date = ?, status = ?, receipt_ID = ? WHERE order_ID = ?");
        $stmt->bind_param( "ssss", $date, $status, $TxnID, $PaymentID );
        $stmt->execute();

        $_SESSION['result'] = "Failed!";
		$_SESSION['message'] = "Payment failed.Please try again";
		$_SESSION['icon'] = "error";
        header( "Location: ../error.php" );
        exit();

    }

    // 1 - SUCCESS / 2 - IN PROGRESS
    if($TxnStatus == '1' || $TxnStatus == '2'){

        $status = 'success';

        $stmt = $con->prepare("UPDATE payment SET date = ?, status = ?, receipt_ID = ? WHERE order_ID = ?");
        $stmt->bind_param( "ssss", $date, $status, $TxnID, $PaymentID );
        $stmt->execute();

        $stmt = $con->prepare("UPDATE menuorder SET status = ? WHERE order_ID = ?");
        $stmt->bind_param( "ss", $status, $PaymentID );
        $stmt->execute();

         $_SESSION['result'] = "Success!";
		$_SESSION['message'] = "Payment success! Show a receipt as your proof payment.";
		$_SESSION['icon'] = "success";
        header( "Location: ../thankyou_receipt.php?id=".base64_encode($TxnID) );
        exit();
    }
} else {

    //echo "$pass.$TxnStatus.$PaymentID.$TxnID.$TxnMessage;";
    $_SESSION['result'] = "Failed!";
    $_SESSION['message'] = "Something wrong.";
    $_SESSION['icon'] = "error";
    header( "Location: ../cart2.php" );
    exit();

}

?>