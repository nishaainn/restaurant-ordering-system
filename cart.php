<?php
  session_start();
  require('config/database.php');
  require('config/ipAddress.php');

   
  
    $menu = "menu";
    $menu2 = "QRISPY PIZZA'S CART";
    $total1 = 0;

    $sql = "SELECT cart.ID,menu.menuid,image,name,price,category,ipAddress,quantity FROM menu INNER JOIN cart ON menu.menuid = cart.menuid WHERE ipAddress = '$ip_address'";  
    $result = mysqli_query($con, $sql);
    $total = mysqli_num_rows($result);
    while($row = $result->fetch_array(MYSQLI_BOTH)){
        $id[]=$row['ID'];
        $menuID[]=$row['menuid'];
        $image[]=$row['image'];
        $name[]=$row['name'];
        $price[]=$row['price'];
        $category[]=$row['category'];
        $ipaddress[] = $row['ipAddress'];
        $quantity[] = $row['quantity'];
    
        $total1=$total1+ ($row['price']*$row['quantity']);
    }



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
    <title><?php echo $menu2;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <link rel="stylesheet" href="assets/css/aos.css">

    <link rel="stylesheet" href="assets/css/ionicons.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/icomoon.css">
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  
  <body>
    <!--NAVBAR-->
  	<?php include "include/navbar.php";?>
    
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center mb-5 pb-3">
				<div class="col-md-7 heading-section ftco-animate text-center">
					<h2 class="mb-4 text-primary">Your Cart</h2>
					<p style = "color:white;"><b>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
				</div>
			</div>
		</div>
    </section>
    <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
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
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><?php echo $category[$a];?></strong></p>
                                    <p><?php echo $name[$a];?></p>
                                    <p>Price: RM<?php echo $price[$a];?></p><br><br>
                                    
                                    <!-- Data -->
                                </div>

                                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <div class="form-outline">
                                            <h6><label class="form-label" for="form1">Quantity : <?php echo $quantity[$a];?></label></h6>
                                        </div>
                                    </div>
                                    <!-- Price -->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <p class="text-start text-md-center">
                                        <strong>Total : RM<?php echo number_format($price[$a]*$quantity[$a],2);?></strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                                <a href = "process/delete.php?id=<?php echo base64_encode($id[$a]); ?>&purpose=deleteCart" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip"
                                    title="Remove item">
                                    <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            <?php }?>
                            </div>
                            <!-- Single item -->

                            <hr class="my-4" />

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                            <h6 class="mb-0"><a href="menu.php" class="text-body"><i class="fa fa-cutlery" aria-hidden="true"></i></i> Back to menu</a></h6><br><br>
                            <form action = "process/checkout.php" method = "post">
                            <?php for($a = 0;$a<$total;$a++){ ?>
                                <input type="hidden" name="menuid[]" value="<?php echo $menuID[$a] . "(" . $quantity[$a] . ")";?>" required>
                            <?php }?>
                                <input type="hidden" name="totalprice" value="<?php echo number_format($total1,2);?>" required>
                                <input type="hidden" name="purpose" value="checkout" required>
                                <button type = "submit" class="btn btn-primary btn-lg btn-block">
                                    Go to checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--footer-->
    <?php include "include/footer.php";?>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/jquery.waypoints.min.js"></script>
  <script src="assets/js/jquery.stellar.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/jquery.animateNumber.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/jquery.timepicker.min.js"></script>
  <script src="assets/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="assets/js/google-map.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>
    
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

    <script>
      var box = "#box<?php echo $id[$a]; ?>";

      $(box).change(function(){
        var value = $(this).val();
        var price = $(this).parent().next().find(".qty");
        var amount = "<?php echo $price[$a]; ?>";
        var total = (value * amount).toFixed(2);

        price.html("RM"+total);

        var total2 = 0;
        $(".qty").each(function(){
          var p = $(this).html().split("RM");
          total2 =  total2 + parseFloat(p[1]);
        });
        $("#subtotal").html("RM"+total2.toFixed(2));
        $("#subtotal2").html("RM"+(total2+6).toFixed(2));
        $("input[name=totalPrice]").val((total2+6).toFixed(2));
      });
    </script>
  </body>
</html>