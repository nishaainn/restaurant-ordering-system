<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");


$count = 1;
$sql1= "SELECT menuorder.ID, menuorder.order_ID, name ,payment.amount,menuorder.date FROM menuorder INNER JOIN payment ON menuorder.order_ID = payment.order_ID WHERE payment.status = 'success' ";  
$result1 = mysqli_query($con, $sql1);
$total1 = mysqli_num_rows($result1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qrispy Pizza - Order Histories</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/logo/pizza1.png" width=100% type="image/x-icon" >
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
                            <h3>Order Histories</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">List Order Histories</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            List Of an Orders
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>orderID</th>
                                        <th>Customer Name</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                        <th><center>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php while($row = $result1->fetch_array(MYSQLI_BOTH)){  ?>
                                    <tr>
                                        <td><?php echo $count++;?></td>
                                        <td><?php echo $row['order_ID'];?></td>
                                        <td><?php echo $row['name'];?></td>
                                        <td>RM <?php echo $row['amount'];?></td>
                                        <td><?php echo $row['date'];?></td>
                                        <td><center><a target = "_blank" href = "vieworder.php?id=<?php echo ($row['order_ID']); ?>" class = "me-3"><i class="fa fa-file" aria-hidden="true"></i></a><a href = "process/delete.php?id=<?php echo base64_encode($row['ID']); ?>&purpose=deleteorder"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>

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
    <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
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