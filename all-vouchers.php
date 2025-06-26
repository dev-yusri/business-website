<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | All Vouchers</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k79sMmlM/XWtDeanhTJguD1mSpVVnu16Oa7KqG6QR8FkTmatlrMfj7meaQ9P35h6yKr6iM0/JuRoZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>


<?php include('includes/header.php');?>

<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1 style="font-size:46px; ">ALL<br>
          OFFERS</h1>
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
    $message[] = '<span style="font-size:14px">Voucher already added to wishlist!</span>';
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
        $message[] = '<span style="font-size:14px">Voucher added to wishlist!</span>';
      } else {
         $message[] = '<span style="font-size:14px">Failed to add voucher to wishlist!</span>';
      }
   }
}

?>

<section class="listing-page" style="min-height:1000px">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
    </div>
    <div class="w-full container">
    <div class="row"> 
<?php $sql = "SELECT tblvoucher.VoucherTitle,tbltype.VoucherType,tblstore.NameStore,tblvoucher.Discount,tblvoucher.Tagline,tblvoucher.id,tblvoucher.voucherEnd,tblvoucher.Vimage1,tblvoucher.TermsC from tblvoucher join tbltype on tbltype.id=tblvoucher.VoucherType join tblstore on tblstore.id=tblvoucher.NameStore WHERE tblvoucher.voucherEnd >= CURDATE() ORDER BY tblvoucher.VoucherTitle ASC";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
?>  

<div class="col-list-2">
<div class="voucher-list p-5">
<table>
  <thead>
    <tr>
      <th style="width:40%"><a href="#terms_<?php echo $result->id; ?>"  data-toggle="modal" data-dismiss="modal">
      <form method="post" action="">
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
          <div>
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
    <input type="hidden" name="voucher_image" value="<?php echo htmlentities($result->Vimage1);?>">
         <input type="hidden" name="voucher_type" value="<?php echo htmlentities($result->VoucherType);?>">
         <input type="hidden" name="voucher_store" value="<?php echo htmlentities($result->NameStore);?>">
         <input type="hidden" name="voucher_title" value="<?php echo htmlentities($result->VoucherTitle);?>">
         <input type="hidden" name="voucher_discount" value="<?php echo htmlentities($result->Discount);?>">
         <input type="hidden" name="voucher_tagline" value="<?php echo htmlentities($result->Tagline);?>">
         <input type="hidden" name="voucher_duration" value="<?php echo htmlentities($result->voucherEnd);?>">
         <input type="hidden" name="voucher_terms" value="<?php echo htmlentities($result->TermsC);?>">
    <button type="submit" name="add_to_cart">
              <i class="fa fa-heart-o mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> 
  </button>
            </li>
            <?php } else { ?>
                <li><a href="#loginform" class="login_btn" data-toggle="modal" data-dismiss="modal"> <i class="fa fa-heart-o mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> </a></li>
                <?php } ?></li>
  <li><div class="countdown" data-id="<?php echo $result->id; ?>" data-end="<?php echo (new DateTime($result->voucherEnd))->format('Y-m-d H:i:s'); ?>">
  <div class="text-m text-white bg-red-500 inline-block p-1" style="font-size:10px"><a class="countdown-item" data-id="days"></a> days left</div>
            <div class="countdown-item" data-id="hours" style="display:none">00</div>
            <div class="countdown-item" data-id="minutes" style="display:none">00</div>
            <div class="countdown-item" data-id="seconds" style="display:none">00</div>
        </div></li>
            </form>
</ul>
</div>
            </th>
            </td>
            </table>
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

<?php include('includes/modal.php');?>

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

</body>
</html>
