<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable - Mazer Admin Dashboard</title>

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
                            <h3>Add Qrispy Pizza's Menu</h3>
                            <p class="text-subtitle text-muted">Pizza & Beverages</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Menu</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> New Food & Beverages Details Form</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" action="process/add.php" method = "post" enctype = "multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>List of Category</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <select class="form-select" name="category" required>
                                                            <option>Choose Category</option>
                                                            <option>Pizza</option>
                                                            <option>Beverages</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Image</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="file" class="form-control" name="image"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Menu's Name</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="California Pizza" name="menu_name"required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Menu ID</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="CP-00009" name="menu_code" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Menu's Description</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                    <textarea class="form-control" name="description" placeholder="Description Menu" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Price (RM)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control min="0" max="10000" step="1" name="price" placeholder="20.80" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                            <input type="hidden" name="purpose" value="addMenu" required>
                                                <button type="submit"
                                                    class="btn btn-primary me-1 mb-1">Submit</button>
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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