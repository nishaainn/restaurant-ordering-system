<?php
  session_start();
  require('config/database.php');
  require('config/ipAddress.php');

   
  
    $menu = "menu";
    $menu2 = "QRISPY PIZZA'S MENU";
    $total1 = 0;

    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    $id = base64_encode($id);

    $sql = "SELECT cart.ID,menu.menuid,image,name,price,category,ipAddress,quantity FROM menu INNER JOIN cart ON menu.menuid = cart.menuid WHERE ipAddress = '$ip_address' ";  
    $result = mysqli_query($con, $sql);
    $total = mysqli_num_rows($result);
    while($row = $result->fetch_array(MYSQLI_BOTH)){
        $menuID[]=$row['menuid'];
        $image[]=$row['image'];
        $name[]=$row['name'];
        $price[]=$row['price'];
        $category[]=$row['category'];
        $ipaddress[] = $row['ipAddress'];
        $quantity[] = $row['quantity'];
    
        $tax = 3.67;
        $subtotal = $subtotal + ($row['price'] * $row['quantity']);
        $total1 = $subtotal + $tax;
    }

    $sql1 = "SELECT * FROM payment WHERE receipt_ID = '$id'" ;
    $result1= mysqli_query($con, $sql1);
    $total2 = mysqli_num_rows($result1);
    


    // $sql1 = "SELECT invoice_id, description,payment_amount FROM payment INNER JOIN cart WHERE ipAddress = '$ip_address'";
    // $result1 = mysqli_query($con, $sql1);
    // $total2 = mysqli_num_rows($result1);
    // while($row = $result->fetch_array(MYSQLI_BOTH)){
    //     $invoice_id = 'invoice_id';
    // }


    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THANK YOU</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="jumbotron text-center">
  <h1 class="display-3">Thank You!</h1>
  <p class="lead"><strong>Your Order will be received soon! </strong> Thank you for your orders.</p>
  <hr>
  <p>
    Having trouble? <a href="contact.php" target="_blank">Contact us</a><br>
    View Receipt? <a href="receipt.php?id=<?php echo ($row['receipt_ID']); ?>" target="_blank" >Click Here</a>
  </p>
  <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h1 class="fw-bold mb-0 text-black" style = "color:black;">Your Cart - <?php echo $total;?> items</h1>
                        </div>
                        <div class="card-body">
                            <!-- Single item -->
                            <div class="row">
                            <?php for($a = 0;$a<$total;$a++){ ?>
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="assets/images/menu/<?php echo $image[$a];?>" width=150px;/>
                                    </div><br><br>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><?php echo $category[$a];?></strong></p>
                                    <p><?php echo $name[$a];?></p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                    <!--Price-->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <p>Price: RM<?php echo $price[$a];?></p><br><br>
                                    </div>
                                    <!-- Quantity -->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <div class="form-outline">
                                            <h6><label class="form-label" for="form1">Quantity : <?php echo $quantity[$a];?></label></h6>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                    <!-- Total Price -->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <p class="text-start text-md-center">
                                        <strong>Total : RM<?php echo number_format($price[$a]*$quantity[$a],2);?></strong>
                                        </p>
                                    </div>
                                </div>
                            <?php }?>
                            </div>
                            <!-- Single item -->

                            <hr class="my-4" />

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0" style="color:black;">Summary</h5>
                        </div>
                        <div class="card-body">
                        
                            <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Products :
                                <span><?php echo $total;?> Items</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                <strong>Total amount : </strong>
                                </div>
                                <span style = "color:red">RM<?php echo number_format($total1,2);?></span>
                            </li>
                            </ul><br><br><br>
                            View Receipt
                            <div class = "text-right">
                                <a href="receipt.php?id=<?php echo ($row['receipt_ID']); ?>" target="_blank">
                                    <i class="fa fa-arrow-right" style = "color:black" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>

<!--SWEET ALERT-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<?php if(isset($_SESSION['result']) && $_SESSION['result'] != ""){?> <!-- isset = check ada atau tak & name mesti tak kosong -->
		<script>
		Swal.fire({
				title: '<?php echo $_SESSION['result']; ?>',
				text: '<?php echo $_SESSION['message']; ?>',
				icon: '<?php echo $_SESSION['icon']; ?>'
			})
		</script>
		<?php unset($_SESSION['result']); }?> <!--tak keluar result banyak kali-->

</body>
</html>