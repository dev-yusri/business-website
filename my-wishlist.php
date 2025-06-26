<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?> 

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | My Wishlist</title>

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
  
<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
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
      <div class="flex items-center justify-center mb-10" style="float:left">
          <div style="flex: 1">
          <table>
            <td><th>        
            <i class="fa fa-user-circle user-icon text-white text-9xl"></i></div>
</th>
     <th>     <div><h3 class="text-4xl font-medium text-white ml-10 mb-5"><?php echo htmlentities($result->FullName);?> <c class="text-2xl italic"><?php echo htmlentities($result->EmailId);?></c></h3>
     <h3 class="text-4xl font-semibold ml-10 text-white mb-5"><?php echo htmlentities($result->City);?>, <?php echo htmlentities($result->uState);?></h3>
     <a href="profile.php"><h3 class="text-3xl font-semibold ml-10 text-white underline">Setting</h3></a>
    </div></th>

</td>
</table>
</div>
      </div>
    </div>
  </div>
</section>

<?php
session_start();
$email=$_SESSION['login'];

if (isset($_POST['add_to_cart'])) {
   $voucher_title = filter_var(trim($_POST['voucher_title']), FILTER_SANITIZE_STRING);
   $voucher_store = filter_var(trim($_POST['voucher_store']), FILTER_SANITIZE_STRING);
   $voucher_image = filter_var(trim($_POST['voucher_image']), FILTER_SANITIZE_STRING);
   $voucher_tagline = filter_var(trim($_POST['voucher_tagline']), FILTER_SANITIZE_STRING);
   $voucher_discount = filter_var(trim($_POST['voucher_discount']), FILTER_SANITIZE_STRING);
   $voucher_type = filter_var(trim($_POST['voucher_type']), FILTER_SANITIZE_STRING);
   $voucher_duration = filter_var(trim($_POST['voucher_duration']), FILTER_SANITIZE_STRING);
   $voucher_terms = filter_var(trim($_POST['voucher_terms']), FILTER_SANITIZE_STRING);

   $select_cart = $dbh->prepare("SELECT * FROM tbladdwish WHERE VoucherTitle = :voucher_title AND userEmail = :userId");
   $select_cart->bindParam(':voucher_title', $voucher_title);
   $select_cart->bindParam(':userId', $email);
   $select_cart->execute();

   if ($select_cart->rowCount() > 0) {
    echo "<script>alert('Voucher already added to wishlist');</script>";
   } else {
    $insert_cart = $dbh->prepare("INSERT INTO tbladdwish(userEmail, VoucherTitle, NameStore, Vimage1, Tagline, Discount, VoucherType, Voucherduration, TermsC) VALUES(:userId, :voucher_title, :voucher_store, :voucher_image, :voucher_tagline, :voucher_discount, :voucher_type, :voucher_duration, :voucher_terms)");
      $insert_cart->bindParam(':userId', $email,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_title',$voucher_title,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_store',$voucher_store,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_image',$voucher_image,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_tagline',$voucher_tagline,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_discount',$voucher_discount,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_type',$voucher_type,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_duration',$voucher_duration,PDO::PARAM_STR);
      $insert_cart->bindParam(':voucher_terms',$voucher_terms,PDO::PARAM_STR);

      if ($insert_cart->execute()) {
        echo "<script>alert('Voucher added to wishlist');</script>";
      } else {
        echo "<script>alert('Failed to add the voucher');</script>";
      }
   }
}

?>



<section class="listing-page" style="min-height:1200px">
  <div class="container">
  <h1 class="text-5xl font-bold mb-20">My wishlist</h1>
    <div class="row">
    

    <div class="w-full container">
    <div class="row"> 
    <?php 
$useremail=$_SESSION['login'];
 $sql = "SELECT * FROM tbladdwish WHERE userEmail=:useremail";
 $query = $dbh -> prepare($sql);
 $query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
 $query->execute();
 $results=$query->fetchAll(PDO::FETCH_OBJ);
 $cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>



<div class="col-list-1">
<div class="">
<table>
  <thead>
    <tr> 
      <th style="width:20%"><a href="#terms_<?php echo $result->id; ?>"  data-toggle="modal" data-dismiss="modal">
<div class="car-info-box"><img src="admin/img/voucherimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive w-2/3" alt="image">
</div>
</th>
<th>
<div class="car-title-m ml-10">
<h2 class="text-gray-500 font-bold font-6xl mb-2" style="font-size:16px"><?php echo htmlentities($result->VoucherType);?></h2>
<h2 class="text-blue-500 font-normal font-4xl mb-2" style="font-size:16px"><a href="store-details.php?sname=<?php echo htmlentities($result->NameStore); ?>"><?php echo htmlentities($result->NameStore);?></a></h2>
<h2 class="text-black font-bold font-6xl" style="font-size:20px"><?php echo htmlentities($result->VoucherTitle);?></h2>
<h2 class="text-black font-normal font-4xl" style="font-size:16px">Up to <?php echo htmlentities($result->Discount);?> %!</h2>
<h2 class="text-black font-normal font-4xl" style="font-size:16px"><?php echo htmlentities($result->Tagline);?></h2>

</a>
<div class="modal" id="terms_<?php echo $result->id; ?>" >
        <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title flex justify-center align-center font-bold">Terms and Condition</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="">
            <div class="p-5" style="overflow:scroll; height:300px;">
            <p class="font-normal"><?php  echo $result->TermsC; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
</div>

<br>
<ul class="flex pl-0" style="float:left">
  <li><?php if($_SESSION['login']){?>
    <a class="delete_employee" data-emp-id="<?php echo htmlentities($result->id);?>" href="javascript:void(0)">
              <i class="fa fa-heart mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> 
  </a>
            </li>
            <?php } else { ?>
                <li><a href="#loginform" class="login_btn" data-toggle="modal" data-dismiss="modal"> <i class="fa fa-heart-o mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> </a></li>
                <?php } ?></li>
  <li><div class="countdown" data-id="<?php echo $result->id; ?>" data-end="<?php echo (new DateTime($result->Voucherduration))->format('Y-m-d H:i:s'); ?>">
  <div class="text-white bg-red-500 inline-block p-2" style="font-size:10px"><a class="countdown-item" data-id="days"></a> days left</div>
            <div class="countdown-item" data-id="hours" style="display:none">00</div>
            <div class="countdown-item" data-id="minutes" style="display:none">00</div>
            <div class="countdown-item" data-id="seconds" style="display:none">00</div>
        </div></li>   
</ul>
</div>
            </th>
            <th>
<div class="flex align-center justify-center">
<a class="delete_employee" data-emp-id="<?php echo htmlentities($result->id);?>" href="javascript:void(0)">
<i class="fa fa-trash-o" style="font-size:40px;color:red"></i></a>
</div>
</th>
            </td>
            </table>
</div>
</div>

<?php }}  else { ?>
  &nbsp;<h5 class="text-black font-semibold text-4xl">&nbsp; &nbsp;No wishlist item</h5>
              <?php } ?>
</div>

</div>
<?php 
}}?>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var countdowns = document.querySelectorAll('.countdown');

        countdowns.forEach(function (countdown) {
            var id = countdown.dataset.id;
            var end = new Date(countdown.dataset.end);

            function updateClock() {
                var now = new Date();
                var t = end - now;

                if (t <= 0) {
                    countdown.innerHTML = "<h3>Expired</h3>";
                    clearInterval(timeinterval);
                    return;
                }

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                countdown.querySelector('.countdown-item[data-id="days"]').innerHTML = days;
                countdown.querySelector('.countdown-item[data-id="hours"]').innerHTML = hours;
                countdown.querySelector('.countdown-item[data-id="minutes"]').innerHTML = minutes;
                countdown.querySelector('.countdown-item[data-id="seconds"]').innerHTML = seconds;
            }

            var timeinterval = setInterval(updateClock, 1000);
            updateClock(); // run function once at first to avoid delay
        });
    });
</script>
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
<script type="text/javascript" src="assets/js/deleteRecords.js"></script>
<script type="text/javascript" src="assets/js/bootbox.min.js"></script>
</body>
</html>
<?php } ?>
