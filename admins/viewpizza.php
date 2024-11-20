<?php
session_start();
require("../config/database.php");
//require("../config/security.php");
require("../config/ipAddress.php");


$sql1 = "SELECT * FROM menu WHERE status = 'active'" ;
$result1= mysqli_query($con, $sql1);
$total1 = mysqli_num_rows($result1);
while($row = $result1->fetch_array(MYSQLI_BOTH)){
    $id[]=$row['ID'];
    $menuid[]=$row['menuid'];
    $image[]=$row['image'];
    $name[]=$row['name'];
    $desc[]=$row['description'];
    $price[]=$row['price'];
    $category[]=$row['category'];
    $status[] = $row['status'];
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/menu/menustyle.css">

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
            <!--START MENU -->
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>LIST MENU</h3>
                            <p class="text-subtitle text-muted">List Pizzas of QRISPY PIZZA</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> List Menu </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Basic card section start -->
                <section id="content-types">
                    <div class="row">
                        <?php for($a = 0;$a<$total1;$a++){ ?>
                        <?php if($category[$a]== "pizza"){?>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $name[$a];?></h4><hr>
                                        <p class="card-text">
                                            
                                        </p>
                                    </div>
                                    <center><img class="img-fluid w-50" src="../assets/images/menu/<?php echo $image[$a];?>"
                                        alt="Card image cap">
                                </div><br>
                                <div class="card-footer d-flex justify-content-between">
                                    <div class = "text-right">
                                        <button class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#dark<?php echo $menuid[$a];?>" >View</button>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                        <div class="modal fade text-left" id="dark<?php echo $menuid[$a];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel150" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark white">
                                        <span class="modal-title" id="myModalLabel150"><?php echo $name[$a];?></span>
                                        <button type="button" class="close"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <form action="process/update.php" method = "post" enctype = "multipart/form-data">
                                        <div class="modal-body">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">Product Name</label>
                                                    <input type="text" id="first-name-vertical"
                                                        class="form-control" name="prodname" value="<?php echo $name[$a];?>" >
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Product ID</label>
                                                    <input type="email" id="email-id-vertical"
                                                        class="form-control" name="email-id" value="<?php echo $menuid[$a];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="contact-info-vertical">Description</label>
                                                    <textarea class="form-control" name="description" rows="3"><?php echo $desc[$a];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="password-vertical">Price</label>
                                                    <input type="text" id="password-vertical"
                                                        class="form-control" name="price" value="<?php echo $price[$a];?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="password-vertical">Price</label>
                                                    <select class="form-control" name="status">
                                                        <option value="">SELECT STATUS</option>
                                                        <option value="active" <?php if($status[$a] == "active"){ echo "selected";}?>>active</option>
                                                        <option value="inactive" <?php if($status[$a] == "inactive"){ echo "selected";}?>>inactive</option>			
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <input type="hidden" name="menuid" value="<?php echo $menuid[$a];?>" required>
                                            <input type="hidden" name="purpose" value="updatePizza" required>
                                            <button type="submit"
                                                class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="button" class="btn btn-light-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                    </div>
                </section>
                <!-- Basic Card types section end -->
            </div>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

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