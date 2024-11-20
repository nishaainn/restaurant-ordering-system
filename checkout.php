<?php
    session_start();
    require('config/database.php');
    require('config/ipAddress.php');

    $menu = "menu";
    $menu2 = "Qrispy Pizza's Payment Details";

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM menuorder WHERE order_ID = '$id' " ;
	$result = mysqli_query($con, $sql);
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
        $amount = $row['amount'];
    }

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
    
    <section class="h-100 gradient-custom ">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                    <div class="card-header py-3 bg-primary">
                        <h1 class="fw-bold mb-0 text-black" style = "color:black; text-align:center;">Payment Details</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="col-md-8">
                            <form action="process/pay.php" method="post" class="contact-form">
                            <div class="form-group">
                                Name:
                                <input type="text" class="form-control" name = "name" placeholder="Your Name" style = "color:black;" required> 
                            </div>
                            <div class="form-group">
                                Email:
                                <input type="text" class="form-control" name = "email" placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                Phone No:
                                <input type="text" class="form-control" name = "phoneno" placeholder="Your Phone Number">
                            </div>
                            <div class="form-group">
                                Price
                                <input type="text" class="form-control" name = "price" value = "<?php echo $amount;?>" readonly>
                            </div>
                            <div class="form-group">
                                Dine in/Take Away
                                <select class="form-control form-select" aria-label=".form-select-sm example" name="categoryorder">
                                    <option selected>Choose Dine In/Take Away</option>
                                    <option value="dine in">Dine In</option>
                                    <option value="take away">Take Away</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="orderid" value = "<?php echo $id;?>" required>
                                <input type="hidden" name="purpose" value="payment" required>
                                <button class="btn btn-primary py-3 px-5" id=btnSubmit>Check Out</button>
                            </div>
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
  </body>
</html>