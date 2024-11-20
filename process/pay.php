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
$previous = $_SERVER['HTTP_REFERER'];

// MAKE PAYMENT
if($purpose == 'payment'){

    $orderid = filter_input(INPUT_POST, 'orderid', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $phoneno = filter_input(INPUT_POST, 'phoneno', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $category_order = filter_input(INPUT_POST, 'categoryorder', FILTER_SANITIZE_STRING);


    $orderid = filter_form_input($orderid);
    $name = filter_form_input($name);
    $email = filter_form_input($email);
    $phoneno = filter_form_input($phoneno);
    $price = filter_form_input($price);
    $category_order = filter_form_input($category_order);


    //OTHER
    $description = "Payment For " . $orderid;
    $date = date("Y-m-d");

    $sql = "INSERT INTO payment (order_ID,name,email,phoneno,amount,description,date,category_order) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $orderid, $name, $email, $phoneno , $price,$description,$date,$category_order);

    if(!mysqli_stmt_execute($stmt)) {

        $_SESSION['result'] = "Failed!";
        $_SESSION['message'] = "Please try again.";
        $_SESSION['icon'] = "error";
        header( "Location: $previous" );
        exit();
    
    }
} else {

	session_destroy();
    header('Location: ../index.php');
	exit();

}
// END MAKE PAYMENT

// SENANG PAY
$merchantid = "492167047301942";
$key = "5172-96395350";
$tobehash = $key.$description.$price.$orderid;
$hashkey = hash_hmac('sha256', $tobehash, $key);

?>
<html>
<body>
    <h3><center><br><br><br><br>Processing... Please wait. Do not refresh your browser.</center></h3>
    <table align="center" style="display: none;" >
        <tr>
            <td colspan="2">
                <form id="form" method="post" action="https://sandbox.senangpay.my/payment/<?php echo $merchantid; ?>">

                    <input type="hidden" name="detail" value="<?php echo $description; ?>">
                    <input type="hidden" name="amount" value="<?php echo $price; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $orderid; ?>">
                    <input type="hidden" name="hash" value="<?php echo $hashkey; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlentities($name); ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="phone" value="<?php echo $phoneno; ?>">
                    
                    <input type="submit" value="proceed.."/>

                </form>
            </td>
        </tr>
    </table>

    <script>
        document.getElementById("form").submit();
    </script>
</body>
</html>