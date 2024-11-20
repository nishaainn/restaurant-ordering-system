<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$count = 1;
$sql= "SELECT * FROM contact";
$result = mysqli_query($con, $sql);
$total = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - List Payment</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

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
                            <h3>List Messages</h3>
                            <p class="text-subtitle text-muted">List of messages send by customer</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">List Messages</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Customers Messages
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                                    <tr>
                                        <td><?php echo $count++;?></td>
                                        <td class="text-bold-500"><p class="mb-0 font-weight-medium"> 
                                        <div class="d-flex align-items-center">
                                            <div class="table-user-name ml-3">
                                            <p class="mb-0 font-weight-medium"><b><?php echo $row['name'];?> </p> 
                                            </div>
                                        </div>    
                                        </td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo $row['subject'];?></td>
                                        <td>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#inlineForm<?php echo $row['msg_id'];?>"><i class = "fa fa-envelope"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade text-left" id="inlineForm<?php echo $row['msg_id'];?>" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel33"> Messages </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="#">
                                                    <div class="modal-body">
                                                        <label>Name: </label>
                                                        <div class="form-group">
                                                            <input type="text" value = "<?php echo $row['name'];?>"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <label>Email: </label>
                                                        <div class="form-group">
                                                            <input type="email" value = "<?php echo $row['email'];?>"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <label>Subject: </label>
                                                        <div class="form-group">
                                                            <input type="email" value = "<?php echo $row['subject'];?>"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <label>Message: </label>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly ><?php echo $row['message'];?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
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
</body>

</html>