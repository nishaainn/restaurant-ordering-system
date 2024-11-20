<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");

$sql = "SELECT * FROM user WHERE username = '$user' ";
$result= mysqli_query($con, $sql);
$total = mysqli_num_rows($result);
while($row = $result->fetch_array(MYSQLI_BOTH)) { 
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $nric = $row['NRIC'];
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phoneno'];
    $position = $row['position'];
    $status = $row['status'];
}

$dob = substr($nric, 0, 2)."-".substr($nric, 2, 2)."-".substr($nric, 4, 2);  // (index,panjang)
$dob = date('d/m/Y', strtotime($dob));

// GENDER
// $gender = substr($nric, 11, 1);
// if($gender % 2 == 0){ $gender = 'Female'; } else { $gender = 'Male'; }

//AGE
$age = date('Y') - substr($dob,6,4);




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
                            <h3>Edit Profile</h3>
                            <p class="text-subtitle text-muted">Update details information form</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
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
                                <h4 class="card-title">Update Details Information Profile</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" action = "process/update.php" method = "post">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">First Name</label>
                                                    <input type="text" id="first-name-column" class="form-control"
                                                        placeholder="First Name" name="fname" value = "<?php echo $fname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Last Name</label>
                                                    <input type="text" id="last-name-column" class="form-control"
                                                        placeholder="Last Name" name="lname" value = "<?php echo $lname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">NRIC</label>
                                                    <input type="text" id="city-column" class="form-control"
                                                        placeholder="NRIC" name="nric" value = "<?php echo $nric; ?>"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">Age</label>
                                                    <input type="text" id="city-column" class="form-control"
                                                        placeholder="age" name="age" value = "<?php echo $age . "  " . "years old" ; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">NRIC</label>
                                                    <input type="text" id="city-column" class="form-control"
                                                        placeholder="dob" name="dob" value = "<?php echo $dob; ?>"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Username</label>
                                                    <input type="text" id="country-floating" class="form-control"
                                                        name="username" placeholder="Username" value = "<?php echo $username; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="company-column">Email</label>
                                                    <input type="email" id="company-column" class="form-control"
                                                        name="email" placeholder="Email" value = "<?php echo $email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="email-id-column">Phone Number</label>
                                                    <input type="text" id="email-id-column" class="form-control"
                                                        name="phone" placeholder="Phone Number" value = "<?php echo $phone; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email-id-column">Position</label>
                                                    <select class="form-control" name="position">
                                                        <option value="">SELECT POSITION</option>
                                                        <option value="admin" <?php if($position == "admin"){ echo "selected";}?>>admin</option>
                                                        <option value="super admin" <?php if($position == "super admin"){ echo "selected";}?>>super admin</option>		
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email-id-column">Status</label>
                                                        <select class="form-control" name="status">
                                                        <option value="">SELECT STATUS</option>
                                                        <option value="active" <?php if($status == "active"){ echo "selected";}?>>active</option>
                                                        <option value="inactive" <?php if($status == "inactive"){ echo "selected";}?>>inactive</option>			
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <input type="hidden" name="nric" value="<?php echo $nric; ?>" required>
                                                <input type="hidden" name="purpose" value="editprofile" required>
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