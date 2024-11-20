<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");




$sql = "SELECT * FROM user WHERE status = 'active'" ;
$result= mysqli_query($con, $sql);
$total = mysqli_num_rows($result);
while($row = $result->fetch_array(MYSQLI_BOTH)) { 
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $position = $row['position'];
    $image1 = $row['image'];
}

$sql1 = "SELECT * FROM menu WHERE status = 'active'" ;
$result1= mysqli_query($con, $sql1);
$total1 = mysqli_num_rows($result1);

$sql2 = "SELECT * FROM cart WHERE status = 'active'";
$result2= mysqli_query($con, $sql2);
$total2 = mysqli_num_rows($result2);

$sql3 = "SELECT cart.ID,menu.menuid,menu.status,image,name,price,category,ipAddress,quantity FROM menu INNER JOIN cart ON menu.menuid = cart.menuid WHERE cart.status = 'active'  ORDER BY menu.category LIMIT 0,3";  
$result3 = mysqli_query($con, $sql3);
$total3 = mysqli_num_rows($result3);
while($row = $result3->fetch_array(MYSQLI_BOTH)){
    $id[]=$row['ID'];
    $menuID[]=$row['menuid'];
    $image[]=$row['image'];
    $name[]=$row['name'];
    $price[]=$row['price'];
    $category[]=$row['category'];
    $ipaddress[] = $row['ipAddress'];
    $quantity[] = $row['quantity'];
    $status[] = $row['status'];
}

$sql4 = "SELECT cart.ID,menu.menuid,image,name,price,category,ipAddress,quantity FROM menu INNER JOIN cart ON menu.menuid = cart.menuid WHERE cart.status = 'active'  ORDER BY cart.quantity ASC LIMIT 0,5";  
$result4 = mysqli_query($con, $sql4);
$total4 = mysqli_num_rows($result3);
while($row = $result4->fetch_array(MYSQLI_BOTH)){
    $id[]=$row['ID'];
    $menuID[]=$row['menuid'];
    $image[]=$row['image'];
    $name[]=$row['name'];
    $price[]=$row['price'];
    $category[]=$row['category'];
    $ipaddress[] = $row['ipAddress'];
    $quantity[] = $row['quantity'];
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <!--sidebar-->
        <?php include "include/sidebar.php"; ?>
        <!--CONTENT-->
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Registeration Admin</h3>
                            <p class="text-subtitle text-muted">Details Admin Form Registeration</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
                
                <!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Admin Accounts Information</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form action = "process/add.php" method = "post" class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Username</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control"
                                                                placeholder="Username" name="username">
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>NRIC</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control"
                                                                placeholder="NRIC" name = "nric">
                                                            <div class="form-control-icon">
                                                                <i class="fa fa-vcard-o"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="email" class="form-control"
                                                                placeholder="Email" name="email">
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-envelope"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Password</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="password" class="form-control"
                                                                placeholder="Password" name = "password">
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-lock"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br><br>

                                                <div class="card-header">
                                                    <h4 class="card-title">Admin Details Information</h4>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>First Name</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="first-name" class="form-control"
                                                        name="fname" placeholder="First Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Last Name</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="email-id" class="form-control"
                                                        name="lname" placeholder="Last Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Mobile</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="number" id="contact-info" class="form-control"
                                                        name="phone" placeholder="Mobile">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Position</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-select" name="position">
                                                        <option>Choose Position</option>
                                                        <option>Admin</option>
                                                        <option>Super Admin</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                <input type="hidden" name="purpose" value="addAdmin" required>
                                                    <button type="submit"
                                                        class="btn btn-primary me-1 mb-1">Submit</button>
                                                    <button type="reset"
                                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic Horizontal form layout section end -->

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p> &copy; CRISPY PIZZA  <i class = "fa fa-pizza-slice" ></i></p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="dashboard.php">CRISPY PIZZA</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
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