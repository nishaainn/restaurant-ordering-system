<?php

session_start();
require('config/database.php');

$msgid = "M-".rand(000001,999999); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pizza - Free Bootstrap 4 Template by Colorlib</title>
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

    <!--CONTENT-->
    <section class="home-slider owl-carousel img" style="background-image: url(assets/images/bg_1.jpg);">

      <div class="slider-item" style="background-image: url(assets/images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Contact Us</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Contact</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section">
      <div class="container mt-5">
        <div class="row block-9">
					<div class="col-md-4 contact-info ftco-animate">
						<div class="row">
							<div class="col-md-12 mb-4">
	              <h2 class="h4 text-white">Contact Information</h2>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p class = "text-primary"><span>Address:</span> 10th Floor SS15 Courtyard Jln SS 15/4G, Ss 15, 47500 Subang Jaya, Selangor</p>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Phone:</span> <a href="tel:601133694471">(03) 456 7890</a></p>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Website:</span> <a target = "_blank" href="">yoursite.com</a></p>
	            </div>
						</div>
					</div>
					<div class="col-md-1"></div>
          <div class="col-md-6 ftco-animate">
            <form action="process/add.php" method="post" class="contact-form">
            	<div class="row">
            		<div class="col-md-6">
	                <div class="form-group">
	                  <input type="text" class="form-control" name = "name" placeholder="Your Name">
	                </div>
                </div>
                <div class="col-md-6">
	                <div class="form-group">
	                  <input type="email" class="form-control" name = "email" placeholder="Your Email">
	                </div>
	                </div>
              </div>
              <div class="row">
            		<div class="col-md-6">
	                <div class="form-group">
	                  <input type="text" class="form-control" name = "msgid" value = "<?php echo $msgid;?>"readonly>
	                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" name = "subject" placeholder="Subject">
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="hidden" name="purpose" value="contactus" required>
                <button class="btn btn-primary py-3 px-5" id=btnSubmit>Send Message</button>
              </div>
            </form>
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