<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Document</title>
</head>
<body>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="dashboard.php"><center><span> QRISPY </span><i class = "fas fa-pizza-slice"></i></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item  ">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-cutlery fa-lg"></i>
                                <span>Menus</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="addMenu.php">Add Menu</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="viewpizza.php">View Pizza</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="viewdrinks.php">View Drinks</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stickies-fill"></i>
                                <span>Orders</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="activeorder.php">Active Orders</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="orderhistories.php">Order Histories</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="listpayment.php" class='sidebar-link'>
                                <i class="bi bi-credit-card-fill"></i>
                                <span>Payment</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fa  fa-hand-rock-o"></i>
                                <span>Admin</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="addAdmin.php">Add Admin</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="viewAdmin.php">View Admin</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fa fa-cog"></i>
                                <span>Setting</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="editprofile.php">Edit Profile</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="changepassword.php">Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="process/logout.php" class='sidebar-link'>
                                <i class="fas fa-door-open"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
</body>
</html>