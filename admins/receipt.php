<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$sql= "SELECT name,email,phoneno,payment.date,receipt_ID,payment.amount,menuorder.listmenu FROM payment INNER JOIN menuorder ON payment.order_ID = menuorder.order_ID WHERE payment.order_ID = '$id'  ";
$result = mysqli_query($con, $sql);
$total = mysqli_num_rows($result);
while($row = $result->fetch_array(MYSQLI_BOTH)) {
    $name = $row['name'];
    $email = $row['email'];
    $phoneno = $row['phoneno'];
    $orderid = $row['order_ID'];
    $date = $row['date'];
    $receiptid = $row['receipt_ID'];
    $amount = $row['amount'];
    $listmenu = $row['listmenu'];
}

$menu = explode(",",$listmenu);
$totalmenu = count($menu);
for($a=0;$a<$totalmenu;$a++){
    $exp = explode("(",$menu[$a]); //buang kurungan
    $item = $exp[0]; //menuid
    $exp2 = explode(")", $exp[1]);
    $qty = $exp2[0];

    $sql= "SELECT * FROM menu WHERE menuid = '$item'";
    $result = mysqli_query($con, $sql);
    while($row = $result->fetch_array(MYSQLI_BOTH)) {
        $menuname[] = $row['name'];
        $description[] = $row['description'];
        $price[] = $row['price'];
        $quantity[] = $qty;

        
    }
    // echo $menuname[$a];

}
// exit();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qrispy Pizza - receipt customer</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/logo/pizza1.png" width=100% type="image/x-icon" >
    
    <style>
     body{
    background-color: #000;
    }

    .padding{
    padding: 2rem !important;
    }

    .card {
    margin-bottom: 30px;
    border: none;
    -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    }

    .card-header {
    background-color: #fff;
    border-bottom: 1px solid #e6e6f2;
    }

    h3 {
    font-size: 20px;
    }

    h5 {
    font-size: 15px;
    line-height: 26px;
    color: #3d405c;
    margin: 0px 0px 15px 0px;
    font-family: 'Circular Std Medium';
    }

    .text-dark {
    color: #3d405c !important;
    }
</style>



</head>
<body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-header p-4">
                <a class="pt-2 d-inline-block" data-abc="true"><img src="assets/images/logo/qrispyPizza.png" alt="logo" width=30%></a>
                <div class="float-right"> <h3 class="mb-0">Invoice <?php echo $receiptid;?> </h3>
                    Date: <?php echo $date;?>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h5 class="mb-3">To:</h5>
                        <h3 class="text-dark mb-1"><?php echo $name;?> </h3>
                        <div><?php echo $email;?></div>
                        <div><?php echo $phoneno;?></div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th class="right">Price</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($a=0;$a<$totalmenu;$a++){ ?>
                            <tr>
                                <td class="center"><?php echo $a+1;?></td>
                                <td class="left strong"><?php echo $menuname[$a];?></td>
                                <td class="right">RM <?php echo $price[$a];?></td>
                                <td class="center"><?php echo $quantity[$a];?></td>
                                <td class="right">RM <?php echo number_format($price[$a]*$quantity[$a],2);?></td>
                            </tr>
                        <?php  } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">
                </div>
                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left"><strong class="text-dark">Total</strong></td>
                                <td class="right"><strong class="text-dark">RM <?php echo $amount;?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer>
            <div class="card-footer bg-white">
                
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                            href="dashboard.php">CRISPY PIZZA</a></p>
                </div>
            </div>
            
        </footer>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>
</body>
</html>