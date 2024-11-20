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
  <div class="container mt-5 mb-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="d-flex flex-row p-2"> <img src="admins/assets/images/logo/pizza1.png" width="48">
                        <div class="d-flex flex-column"> <h4 class="font-weight-bold">QRISPY PIZZA</h4> <small><?php echo $total;?> items</small> </div>
                    </div>
                    <hr>
                    <div class="table-responsive p-2">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="add">
                                    <td>From</td>
                                </tr>
                                <tr class="content">
                                    <td class="font-weight-bold">Qrispy Pizza<br> 10th Floor SS15 Courtyard Jln SS 15/4G, Ss 15, 47500 Subang Jaya <br> Selangor,Malaysia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="products p-2">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="add">
                                    <td>Description</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <td class="text-center">Total</td>
                                </tr>
                                <?php for($a = 0;$a<$total;$a++){ ?>
                                    <tr class="content">
                                        <td><?php echo $name[$a];?></td>
                                        <td><?php echo $quantity[$a];?></td>
                                        <td>RM<?php echo $price[$a];?></td>
                                        <td class="text-center">RM<?php echo number_format($price[$a]*$quantity[$a],2);?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="products p-2">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="add">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="content">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">Total Price : RM<?php echo number_format($total1,2);?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
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