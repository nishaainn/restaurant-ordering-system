<?php
session_start();
require("../config/database.php");
// require("../config/security.php");




?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Qrispy Pizza Admin Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/assets/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/images/logo/pizza1.png" width=100% type="image/x-icon" >

    <!-- Google fonts -->
    <link href="https:/fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
                        
                        <div class="details">
                        <!--result-->
                        

                        <img src="assets/images/logo/qrispyPizza.png" alt="logo" width=40%>
                        <br><br>
                            <form action="process/signin.php" method="POST">
                                <div class="form-group clearfix">
                                    <input name="username" type="text" class="form-control" placeholder="Username" aria-label="Email" required>
                                </div>
                                <div class="form-group clearfix">
                                    <div class = "col d-flex">
                                        <input id = "password" name="password" type="password" class="form-control" autocomplete="off" placeholder="Password" aria-label="Password" required  >
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>      
                                    </div>
                                </div>
                                <div class="checkbox form-group clearfix">
                                    <div class="form-check float-start">
                                       
                                    </div>
                                    <a href="forgotpassword.php" class="link-light float-end forgot-password">Forgot your password?</a>
                                </div>
                                <div class="form-group clearfix fg">
                                    <input type="hidden" name="purpose" value="login" required>
                                    <button type="submit" class="btn btn-lg btn-primary btn-theme"><span>Login</span></button>
                                </div>
                                
                            </form>
                            <div class="clearfix"></div>
                        </div>
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
<script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>
<script>
    $(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
    input.attr("type", "text");
    } else {
    input.attr("type", "password");
    }
    });
</script>
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
