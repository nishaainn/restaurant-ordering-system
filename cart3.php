<?php

session_start();
require("config/database.php");
require("config/ipAddress.php");

$sql = "SELECT cart.ID,menu.menuid,image,name,price,category,ipAddress,quantity FROM menu INNER JOIN cart ON menu.menuid = cart.menuid WHERE ipAddress = '$ip_address'";  
$result = mysqli_query($con, $sql);
$total = mysqli_num_rows($result);
while($row = $result->fetch_array(MYSQLI_BOTH))
{
  $quantity[] = $row['quantity'];
  $image[] = $row['image'];
  $name[] = $row['name'];
  $price[] = $row['price'];
  $id[] = $row['id'];
  $menu_id[] = $row['menu_id'];
  
  $delivery = 6;
  $subtotal = $subtotal + ($row['price'] * $row['quantity']);
  $total1 = $subtotal + $delivery;
}

?>

<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> Tiffin's </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="assets/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="assets/css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>
    <!-- header section strats -->
    <?php include "include/header.php"?>
    <!-- end header section -->
  </div>

  <!-- cart section starts-->
  <section class="h-100" style="background-color: #eee;">
  <div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>
          
        </div>
        <?php for($w = 0; $w<$total; $w++ ) {?>
          <div class="card rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-md-2 col-lg-2 col-xl-2">
                      <img src="images<?php echo $image[$w]; ?>" alt="" style="height: 100px;">
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3">
                      <p class="lead fw-normal mb-2"><?php echo $name[$w]; ?></p>
                    </div>

                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                      <input id="box<?php echo $id[$w]; ?>" min="1" name="quantity" value="<?php echo $quantity[$w]; ?>" type="number" class="form-control form-control-sm" />
                    </div>

                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                      <h5 class="qty mb-0">RM<?php echo number_format($price[$w]*$quantity[$w], 2); ?></h5>
                    </div>
                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                      <a href="process/delete.php?id=<?php echo base64_encode($id[$w]); ?>&p=deleteCart" class="text-danger"><i class="fa fa-trash fa-lg"></i></a>
                    </div>
                </div>
            </div>
          </div>
        <?php } ?>
        <div class="card">
          <div class="card-body">
            <div class="row d-flex justify-content-between align-items-center">
              <div class="col-md-3 col-lg-3 col-xl-3">
                <p class="lead fw-normal mb-2">Subtotal</p>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                <p><span id="subtotal" class="text-muted">RM<?php echo number_format($subtotal, 2)?></span></p>
              </div>
            </div>
            <div class="row d-flex justify-content-between align-items-center">
              <div class="col-md-3 col-lg-3 col-xl-3">
                <p class="lead fw-normal mb-2">Delivery Fee</p>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                <p><span class="text-muted">RM6.00</span></p>
              </div>
            </div>
            <div class="row d-flex justify-content-between align-items-center">
              <div class="col-md-3 col-lg-3 col-xl-3">
                <p class="lead fw-normal mb-2">Total</p>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                <p><span id="subtotal2" class="text-muted">RM<?php echo number_format($total1, 2)?></span></p>
              </div>
            </div>
            <form action="process/checkout.php" method="post">
            <?php for($w = 0; $w<$total; $w++ ) { ?>
              <input type="hidden" name="menuList[]" value="<?php echo $menu_id[$w]."(".$quantity[$w].")"; ?>" required>
            <?php }?>
              <input type="hidden" name="totalPrice" value="<?php echo number_format($total1, 2)?>" required>
              <input type="hidden" name="purpose" value="checkout" required>
              <button type="submit" class="btn btn-dark btn-block btn-lg-3">Checkout</button>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- cart section ends-->

  <!-- footer section -->
  <?php include("include/footer.php"); ?>
  <!-- footer section -->

  <!-- jQery -->
  <script src="assets/js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script> -->
  <!-- custom js -->
  <script src="assets/js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

  <!-- Sweet Alert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- End Sweet Alert-->

  <?php if(isset($_SESSION['result']) && $_SESSION['result'] != '') { ?>
    <script>
          Swal.fire({
          icon: '<?php echo $_SESSION['icon']; ?>',
          text: '<?php echo $_SESSION['result']; ?>',
        })
    </script>
  <?php } unset($_SESSION['result']); ?>


  <?php for($w = 0; $w<$total; $w++ ) {?>
    <script>
      var box = "#box<?php echo $id[$w]; ?>";

      $(box).change(function(){
        var value = $(this).val();
        var price = $(this).parent().next().find(".qty");
        var amount = "<?php echo $price[$w]; ?>";
        var total = (value * amount).toFixed(2);

        price.html("RM"+total);
        var total2 = 0;
        $(".qty").each(function(){
          var p = $(this).html().split("RM");
          total2 =  total2 + parseFloat(p[1]);
        });
        $("#subtotal").html("RM"+total2.toFixed(2));
        $("#subtotal2").html("RM"+(total2+6).toFixed(2));
        $("input[name=totalPrice]").val((total2+6).toFixed(2));
      });
    </script>
  <?php } ?>
</body>

</html>