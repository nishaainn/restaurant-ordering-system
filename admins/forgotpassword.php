<?php

session_start();
require("../config/database.php");

?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Qrispy Pizza - Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/images/logo/pizza1.png" width=100% type="image/x-icon" >

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/assets/css/style.css">

</head>
<body id="top">
<div class="page_loader"></div>

<!-- Login 14 start -->
<div class="login-14">
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-section">
                    <div class="form-inner">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets/images/logo/qrispyPizza.png" alt="logo" style = "width:150px" >
                            </a>
                        </div>
                        <div class="details">
                            <h3>Recover Your Password</h3>
                            <form action="process/verify.php" method="POST">
                                <div class="form-group clearfix">
                                    <input  type="email" class="form-control" name= "email" placeholder="Email" aria-label="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="purpose" value="forgotpassword" required>
                                    <button type="submit" class="btn btn-lg btn-primary btn-theme"><span>Send Me Email</span></button>
                                </div>
                                <div class="clearfix"></div>
                                
                            </form>
                            <div class="clearfix"></div>
                        </div>
                        <p>Already a member? <a href="index.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 14 end -->

<!-- External JS libraries -->
<script src="assets/assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/assets/js/jquery.validate.min.js"></script>
<script src="assets/assets/js/app.js"></script>

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

<!-- Custom JS Script -->
</body>
</html>
