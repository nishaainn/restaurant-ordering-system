<?php
  session_start();
  require('config/database.php');
  require('config/ipAddress.php');

  
  $menu = "menu";
  $menu2 = "QRISPY PIZZA'S MENU";

  $sql = "SELECT * FROM menu ORDER BY ID ASC";
  $result = mysqli_query($con, $sql);
  $total = mysqli_num_rows($result);
  while($row = $result->fetch_array(MYSQLI_BOTH)){
    $id[]=$row['ID'];
    $menuid[]=$row['menuid'];
    $image[]=$row['image'];
    $name[]=$row['name'];
    $desc[]=$row['description'];
    $price[]=$row['price'];
    $category[]=$row['category'];
 }



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pizza - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <link rel="stylesheet" href="assets/css/aos.css">

    <link rel="stylesheet" href="assets/css/ionicons.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/icomoon.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        p{
            color:#ffffff;
        }
        </style>
  </head>
  <body>
    <!--NAVBAR-->
  	<?php include "include/navbar.php";?>

    <!--CONTENT-->
    <section class="home-slider owl-carousel img" style="background-image: url(assets/images/bg_1.jpg);">

      <div class="slider-item" style="background-image: url(assets/images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">
            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Our Menu</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Menu</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
	    <section class="ftco-menu">
    	<div class="container-fluid">
      <div class="col-lg-12 ftco-animate p-md-5">
				<div class="row">
					<div class="col-md-12 nav-link-wrap mb-5">
						<div class="nav ftco-animate nav-pills justify-content-center " id="v-pills-tab" role="tablist" aria-orientation="vertical">
							<a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Pizza</a>
							<a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Drinks</a>
						</div>
					</div>
					<div class="col-md-12 d-flex align-items-center">
						<div class="tab-content ftco-animate" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                    <div class="row">
                      <?php for($a = 0;$a<$total;$a++){ ?>
                        <?php if($category[$a]== "pizza"){?>
                        <div class="col-md-4 text-center">
                            <div class="menu-wrap">
                              <br>
                                <a href="#" class="menu-img img mb-4" style="background-image: url(assets/images/menu/<?php echo $image[$a];?>);"></a>
                                <div class="text">
                                    <h3><a href="#"><?php echo $name[$a];?></a></h3>
                                    <p><?php echo $desc[$a];?></p>
                                    <p class="price"><span>RM<?php echo $price[$a];?></span></p>
                                    <p><a href="#" class="btn btn-white btn-outline-white" data-toggle="modal" data-target="#exampleModal<?php echo $id[$a];?>">Add to cart</a></p>
                                </div>
                                
                            </div>
                        </div>
                        <?php }}?>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                    <div class="row">
                      <?php for($a = 0;$a<$total;$a++){ ?>
                        <?php if($category[$a]== "drink"){?>
                        <div class="col-md-4 text-center">
                            <div class="menu-wrap">
                                <a href="#" class="menu-img img mb-4" style="background-image: url(assets/images/menu/<?php echo $image[$a];?>);"></a>
                                <div class="text">
                                    <h3><a href="#"><?php echo $name[$a];?></a></h3>
                                    <p><?php echo $desc[$a];?></p>
                                    <p class="price"><span>RM<?php echo $price[$a];?></span></p>
                                    <p><a href="#" class="btn btn-white btn-outline-white" data-toggle="modal" data-target="#exampleModal<?php echo $id[$a];?>">Add to cart</a></p>
                                </div>
                            </div>
                        </div>
                      <?php }}?>
                    </div>
                </div>
            </div> 
					</div>
		        </div>
		    </div><!--first col-->
    	</div>
      <?php for($a = 0;$a<$total;$a++){ ?>
        <div class="modal fade" id="exampleModal<?php echo $id[$a];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">FOOD AND BEVERAGES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="menu-wrap">
                    <form action = "process/add.php" method = "post">
                        <a href="#" name = "product" class="menu-img img mb-4" style="background-image: url(assets/images/menu/<?php echo $image[$a];?>);"></a>
                        <div class="text">
                            <h3 name = "name"><?php echo $name[$a];?></h3>
                            <p style = "color:black"><?php echo $desc[$a];?></p>
                            <div class = "d-flex justify-content-around" style="display:flex; ">
                                <div class = text-left>
                                    <h3 class="price" name = "price"><span>RM<?php echo $price[$a];?></span></h3>
                                    <input type="hidden" name="price" value="<?php echo $price[$a];?>">
                                </div>
                                <div class = text-right>
                                    <label for="qty">Quantity:</label>
                                    <input type="number" name="quantity" min="1" max="100" required>
                                </div><br><br>
                            </div>
                        </div>
                        <div class = text-right>
                          <input type="hidden" name="purpose" value="addtocart" required>
                          <input type="hidden" name="menuid" value="<?php echo $menuid[$a];?>" required>
                          <button type = "submit" class="btn btn-primary">Add To Cart</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>  
              </div>
            </div>
          </div>
        </div>
      <?php }?>
    </section>
    <!--footer-->
    <?php include "include/footer.php";?>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/jquery.waypoints.min.js"></script>
  <script src="assets/js/jquery.stellar.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/jquery.animateNumber.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/jquery.timepicker.min.js"></script>
  <script src="assets/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="assets/js/google-map.js"></script>
  <script src="assets/js/main.js"></script>
    
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