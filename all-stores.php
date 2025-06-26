<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | Stores</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


<?php include('includes/header.php');?>

<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <div class="flex items-center justify-center mb-10" style="float:left">
          <div style="flex: 1">
          <img src="assets/images/icons8-map-marker-96.png" class="w-56 h-56" alt="Map marker icon"></div>
          <div><h2 style="font-size:36px; margin-left:10px">STORES</h2></div>
</div>
      </div>
    </div>
  </div>
  
</section>

<section class="listing-page" style="min-height:1000px">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
      </div>
    </div>
    <div class="w-full container">
      <div class="row">
        <?php
        
        $sql = "SELECT tblstore.logoStore,tblstore.id,tblstore.NameStore from tblstore ORDER BY tblstore.NameStore ASC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
          foreach ($results as $result) {
        ?><a href="store-details.php?vhid=<?php echo htmlentities($result->id); ?>">
            <div class="flex items-center justify-center mb-10" style="float:left">
              <div class="car-info-box">
                
                  <img src="admin/img/voucherimages/<?php echo htmlentities($result->logoStore); ?>" class="img-responsive rounded-full w-56 h-56" alt="image">
               
              </div>
              <div class="car-title-m">
                <h2 class="text-black font-bold font-4xl mb-2 ml-3" style="font-size:26px"><?php echo htmlentities($result->NameStore); ?></h2>
              </div>
            </div> </a>
            <hr class="border-b border-gray-300 w-full h-5">
        <?php
          }
        }
        ?>
      </div>
    </div>
  </section>


  
<?php include('includes/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<?php include('includes/login.php');?>


<?php include('includes/forgotpassword.php');?>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
