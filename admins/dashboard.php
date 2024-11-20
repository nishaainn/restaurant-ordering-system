<?php
session_start();
require("../config/database.php");
require("../config/security.php");
require("../config/ipAddress.php");


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM user WHERE username = '$user' AND status = 'active'" ;
$result= mysqli_query($con, $sql);
$total = mysqli_num_rows($result);
while($row = $result->fetch_array(MYSQLI_BOTH)) { 
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $position = $row['position'];
    $nric = $row['NRIC'];
}
$sqluser = "SELECT * FROM user WHERE status = 'active'" ;
$resultuser = mysqli_query($con, $sqluser);
$totaluser = mysqli_num_rows($resultuser);
// GENDER
$gender = substr($nric, 11, 1);
if($gender % 2 == 0){
     $gender = 'Female'; 
} 
else{
    $gender = 'Male'; 
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

$sql4= "SELECT menuorder.order_ID, name ,payment.amount,menuorder.date FROM menuorder INNER JOIN payment ON menuorder.order_ID = payment.order_ID WHERE payment.status = 'success' ";  
$result4 = mysqli_query($con, $sql4);
$total4 = mysqli_num_rows($result4);
while($row = $result4->fetch_array(MYSQLI_BOTH)){
    $orderid[] = $row['order_ID'];
    $name[] = $row['name'];
    $amount[] = $row['amount'];
    $date[] = $row['date'];

}

$sql5= "SELECT * FROM contact LIMIT 0,3" ;  
$result5 = mysqli_query($con, $sql5);
$total5 = mysqli_num_rows($result5);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qrispy Pizza - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

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
                <h3>Welcome back ! <?php echo $fname. " " .$lname;?>  </h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon purple">
                                                    <i class="iconly-boldProfile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Active Admin</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $totaluser; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon blue">
                                                    <i class="fas fa-pizza-slice " style="font-size: 1.75em;"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Pizzas And Beverages</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $total1; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon green">
                                                    <i class="fas fa-edit" style="font-size: 1.75em;"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Active Orders</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $total2; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon red">
                                                    <i class="iconly-boldBookmark"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Order History</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $total4; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row" id="table-striped">
                                <div class="col-12 ">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Active Orders</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <!-- Table with outer spacing -->
                                                <div class="table-responsive">
                                                    <table class="table table-striped mb-0 table-lg">
                                                        <thead>
                                                            <tr>
                                                                <th>Category</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th><center>Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($a = 0;$a<$total3;$a++){ ?>
                                                            <tr>
                                                                <td class="text-bold-500"><p class="mb-0 font-weight-medium"> 
                                                                <div class="d-flex align-items-center">
                                                                    <img src="../assets/images/menu/<?php echo $image[$a];?>" alt="image" style = "width:90px;height:80px"/>
                                                                    <div class="table-user-name ml-3">
                                                                    <p class="mb-0 font-weight-medium"><b><?php echo $category[$a];?> </p>
                                                                    <small> <?php echo $menuID[$a];?></small>
                                                                    </div>
                                                                </div>    
                                                                </td>
                                                                <td><?php echo $name[$a];?></td>
                                                                <td>RM <?php echo $price[$a];?></td>
                                                                <td><b><center><?php echo $quantity[$a];?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-5">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                    <?php if($gender == 'female'){?>
                                        <img src="assets/images/logo/team.png" alt="Face 1">
                                    <?php }else { ?>
                                        <img src="assets/images/logo/team.png" alt="Face 1">
                                    <?php }?>
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold"><?php echo $fname; ?></h5>
                                        <h6 class="text-muted mb-0"><?php echo $position; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Messages</h4><hr>
                            </div>
                            <div class="card-content pb-4">
                                <?php while($row = $result5->fetch_array(MYSQLI_BOTH)){ ?>
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#inlineForm<?php echo $row['msg_id'];?>"><i class = "fa fa-envelope"></i></a>
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1"><?php echo $row['name'];?></h5>
                                            <h6 class="text-muted mb-0"><?php echo $row['email'];?></h6>
                                            <h6 class="text-muted mb-0">Subject : <?php echo $row['subject'];?></h6>
                                        </div>
                                    </div><br>

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
                                <?php }?>
                                <div class="px-4">
                                    <a href = "viewmessage.php"  class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>View Messages</a>
                                </div>
                            </div>
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

    <script src="assets/js/main.js"></script>
    <script src="https://kit.fontawesome.com/5a82c326f1.js" crossorigin="anonymous"></script>
</body>

</html>