<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$sql1= "SELECT menuorder.order_ID, name ,payment.amount,menuorder.date FROM menuorder INNER JOIN payment ON menuorder.order_ID = payment.order_ID WHERE payment.status = 'pending' ";  
$result1 = mysqli_query($con, $sql1);
$total1 = mysqli_num_rows($result1);

$sql= "SELECT name,email,phoneno,category_order,payment.date,receipt_ID,payment.amount,menuorder.listmenu FROM payment INNER JOIN menuorder ON payment.order_ID = menuorder.order_ID WHERE payment.order_ID = '$id'  ";
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
    $category_order = $row['category_order'];


}

$menu = explode(",",$listmenu);
$totalmenu = count($menu);
for($a=0;$a<$totalmenu;$a++){
    $exp = explode("(",$menu[$a]);
    $item = $exp[0];
    $exp2 = explode(")", $exp[1]);
    $qty = $exp2[0];

    $sql= "SELECT * FROM menu WHERE menuid = '$item'";
    $result = mysqli_query($con, $sql);
    while($row = $result->fetch_array(MYSQLI_BOTH)) {
        $menuname[] = $row['name'];
        $description[] = $row['description'];
        $price[] = $row['price'];
        $image[] = $row['image'];
        $quantity[] = $qty;
    }
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRISPY - LIST MENU</title>

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
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    
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
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                            <h3 class="text-dark mb-1">Name : <?php echo $name;?> </h3>
                            <h3 class="text-dark mb-1">Email : <?php echo $email;?> </h3>
                            <h3 class="text-dark mb-1">Date : <?php echo $date;?></h3>
                            <h3 class="text-dark mb-1">Dine In/Take Away :  <?php echo $category_order;?></h3>

                    </div>
                </div>
                <div class="table-responsive-sm">
                    <div class="col-md-12 col-12">
                        <div class="card rounded-3 mb-4">
                        <?php for($a=0;$a<$totalmenu;$a++){?>
                            <div class="card-body p-4">
                                <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-2 col-lg-2 col-xl-2">
                                    <img class="img-fluid w-100" src="../assets/images/menu/<?php echo $image[$a];?>" alt="Card image cap">
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <p class="lead fw-normal mb-2"><?php echo $menuname[$a];?></p>
                                    <p><span class="text-muted">RM <?php echo $price[$a];?></span></p>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                    Quantity : <?php echo $quantity[$a];?>
                                </div>
                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                    <h5 class="mb-0">RM<?php echo number_format($price[$a]*$quantity[$a],2);?></h5>
                                </div>
                                </div>
                            </div>
                        <?php }?>

                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>

       
        </div>
    </div>
    <script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>
</body>
</html>