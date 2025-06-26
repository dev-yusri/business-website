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
<script type="text/javascript" src="admin/js/textarea.js"></script>


</head>

<body>

<?php include('includes/header.php');?>

<section class="page-header listing_page">
<?php
$vhid=intval($_GET['vhid']);
$sname = $_GET['sname']; 
$sql = "SELECT tblstore.logoStore,tblstore.NameStore,tblstore.storeWebsite,tblstore.storeCity,tblstore.storeState,tblstore.id,tblstore.operationHour,tblstore.contactNo,tblstore.Tagline,tblstore.sdescription,tblstore.promoImg from tblstore where tblstore.id=:vhid OR tblstore.NameStore=:sname";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->bindParam(':sname',$sname, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
?>  
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
          <table>
            <td><th><div class="flex items-center justify-center mb-10" style="float:left">
          <div style="flex: 1">
          <img src="admin/img/voucherimages/<?php echo htmlentities($result->logoStore);?>" class="img-responsive w-56 h-56 bg-white rounded-full" alt="image"></div>

         <div><a href="all-stores.php"><h3 class="text-4xl font-semibold text-white ml-10 mb-5">STORES</h3></a>
     <h3 class="text-6xl font-bold ml-10 text-white mb-7"><?php echo htmlentities($result->NameStore);?></h3>
     <a href=<?php echo htmlentities($result->storeWebsite);?>><h3 class="text-3xl font-semibold ml-10 text-white underline"><?php echo htmlentities($result->storeWebsite);?></h3></a>
    </div></th>
    <th class="text-right"><h3 class="text-3xl font-light text-white mb-7 italic"><?php echo htmlentities($result->storeCity);?>, <?php echo htmlentities($result->storeState);?></h3>
    <h3 class="text-3xl font-light text-white mb-7 italic"><?php echo htmlentities($result->operationHour);?></h3>
    <h3 class="text-3xl font-light text-white mb-7 italic"><?php echo htmlentities($result->contactNo);?></h3>
  </th>
</td>
</table>
</div>
      </div>
    </div>
  </div>
</section>

<section class="listing-page" style="min-height:1000px">
  <div class="container ">
    <div class="row ">
      <div class="col-md-6 col-md-offset-3">
    </div>
    <div class="w-full container">
    <div class="row mt-10">  

<div>
  <table>
  <thead>
    <tr>
      <th style="width:40%">
<div class=" mb-10" >
<div><img src="admin/img/voucherimages/<?php echo htmlentities($result->promoImg);?>" class="img-responsive w-2/3" alt="image">
</div></a></th>
<th class="align-top">
<div >
<h2 class="text-black font-semibold mb-20" style="font-size:32px"><?php echo htmlentities($result->Tagline);?></h2>
<p class="font-normal"><?php  echo $result->sdescription; ?> </p>
</div></th>
            </td>
            </table>
</div>
</div>
<?php 
}}?>               
</div>
</div>

            <section class="recent mt-20">
            <?php include('try.php');?>
</section>
</section>
</section>

<?php include('includes/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<?php include('includes/login.php');?>

<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/filter.js"></script>

</body>
</html>