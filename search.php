<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia</title>

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
  <div class="container w-full">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h3 class="text-5xl text-white font-bold">Search Result of "<?php echo $_POST['searchdata'];?>"</h3>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li>Search</li>
      </ul>
    </div>
  </div>
</section>


<section>
<div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <br><br>
          <form action="search.php" method="post" id="header-search-form">
            <input class="text-xl border border-solid p-5 border-black rounded rounded-lg" type="text" placeholder="Search..." name="searchdata" class="form-control" required="true">
            <button type="submit"><i class="fa fa-search text-4xl" aria-hidden="true"></i></button>
          </form>
        </div>
</div>
</div>
</section>

<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
       

<?php 
$searchdata=$_POST['searchdata'];
$sql = "SELECT tblvoucher.VoucherTitle,tbltype.VoucherType,tblvoucher.Discount,tblvoucher.Tagline,tblstore.NameStore,tblvoucher.id,tblvoucher.Vimage1,tblvoucher.voucherEnd,tblvoucher.storeCity,tblvoucher.storeState,tblvoucher.TermsC from tblvoucher join tbltype on tbltype.id=tblvoucher.VoucherType join tblstore on tblstore.id=tblvoucher.NameStore
        WHERE tblvoucher.voucherEnd >= CURDATE() 
        AND (tblvoucher.storeCity LIKE :search 
        OR tbltype.VoucherType LIKE :search 
        OR tblvoucher.storeState LIKE :search 
        OR tblstore.NameStore LIKE :search 
        OR tblvoucher.NameStore LIKE :search 
        OR tblvoucher.VoucherType LIKE :search)";
$query = $dbh -> prepare($sql);
$searchdata = '%'.$searchdata.'%';
$query->bindParam(':search', $searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=$query->rowCount();
?>
<p><span class="text-xl"><?php echo htmlentities($cnt);?> vouchers found.</span></p>
</div>
</div>


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


<h3 class="text-2xl underline font-semibold">List of Vouchers</h3>
<div class="flex flex-wrap -mx-4">
<?php 
$sql = "SELECT tblvoucher.VoucherTitle,tbltype.VoucherType,tblstore.NameStore,tblvoucher.Discount,tblvoucher.Tagline,tblvoucher.id,tblvoucher.voucherEnd,tblvoucher.Vimage1,tblvoucher.isPopular,tblvoucher.TermsC from tblvoucher join tbltype on tbltype.id=tblvoucher.VoucherType join tblstore on tblstore.id=tblvoucher.NameStore 
WHERE tblvoucher.voucherEnd >= CURDATE() 
        AND (tblvoucher.storeCity LIKE :search 
        OR tbltype.VoucherType LIKE :search 
        OR tblvoucher.storeState LIKE :search 
        OR tblstore.NameStore LIKE :search 
        OR tblvoucher.NameStore LIKE :search 
        OR tblvoucher.VoucherType LIKE :search)";
$query = $dbh -> prepare($sql);
$searchdata = '%'.$searchdata.'%';
$query->bindParam(':search', $searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>
<div class="w-full md:w-1/3 px-4 mb-8">

<div class="voucher-list w-3/4 mb-20 p-5">
<form method="post" action=""><a href="#terms_<?php echo $result->id; ?>"  data-toggle="modal" data-dismiss="modal">
<div class="car-info-box flex items-center justify-center"><img src="admin/img/voucherimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive w-2/3" alt="image">
</div>
<div class="car-title-m mt-3">
<h3 class="text-gray-500 font-bold font-9xl" style="font-size:16px"><?php echo htmlentities($result->VoucherType);?></h3>
<h3 class="text-blue-600 font-normal font-4xl mb-2" style="font-size:16px"><a href="store-details.php?sname=<?php echo htmlentities($result->NameStore); ?>"><?php echo htmlentities($result->NameStore);?></a></h3>
<h3 class="text-black font-bold font-6xl" style="font-size:20px"><?php echo htmlentities($result->VoucherTitle);?></h3>
<h3 class="text-black font-4xl" style="font-size:16px">Up to <?php echo htmlentities($result->Discount);?> %!</h3>
<h3 class="text-black font-4xl" style="font-size:16px"><?php echo htmlentities($result->Tagline);?></h3>
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
            <p><?php  echo $result->TermsC; ?></p>
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
  <div class="text-white bg-red-500 inline-block p-1" style="font-size:10px"><a class="countdown-item" data-id="days"></a> days left</div>
            <div class="countdown-item" data-id="hours" style="display:none">00</div>
            <div class="countdown-item" data-id="minutes" style="display:none">00</div>
            <div class="countdown-item" data-id="seconds" style="display:none">00</div>
        </div></li>
            </form>
</ul>
</div>
</div>
            </div>          


      <?php }} ?>
      
         </div><script>
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
            </div>

            <section class="recent">
            <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-gift"></i> Recent Vouchers</h5>
          </div>
          <div class="recent_addedcars">
            <ul>
<?php $sql = "SELECT tblvoucher.*,tbltype.VoucherType,tbltype.id as bid  from tblvoucher join tbltype on tbltype.id=tblvoucher.VoucherType WHERE tblvoucher.voucherEnd >= CURDATE() order by id desc limit 3";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

              <li class="gray-bg">
                <div class="recent_post_img"> <a href="all-vouchers.php"><img src="admin/img/voucherimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="recent_post_title text-xl"> <a href="all-vouchers.php"><?php echo htmlentities($result->VoucherTitle);?></a>
                <h3 class="text-xl text-gray-500"><?php echo htmlentities($result->VoucherType);?></h3>
                  <p class="widget_price text-l">Up to <?php echo htmlentities($result->Discount);?>% discount</p>
                </div>
              </li>
              <?php }} ?>
              
            </ul>
          </div>
        </div>
      </aside>
</section>

            <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
       

          <?php 
$searchdata=$_POST['searchdata'];
$sql = "SELECT tblstore.NameStore,tblstore.storeState,tblstore.storeCity,tblstore.id,tblstore.logoStore from tblstore join tbltype on tbltype.id=tblstore.vtype
WHERE tblstore.NameStore LIKE :search 
        OR tblstore.storeState LIKE :search 
        OR tblstore.storeCity LIKE :search 
        OR tblstore.vtype LIKE :search
        OR tbltype.VoucherType LIKE :search";
$query = $dbh -> prepare($sql);
$searchdata = '%'.$searchdata.'%';
$query->bindParam(':search', $searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=$query->rowCount();
?>
<p><span class="text-xl"><?php echo htmlentities($cnt);?> stores found.</span></p>
</div>
</div>

<h3 class="text-2xl underline font-semibold">List of Stores</h3>
<div class="flex flex-wrap -mx-4">
<?php 
$sql = "SELECT tblstore.* from tblstore join tbltype on tbltype.id=tblstore.vtype
WHERE tblstore.NameStore LIKE :search 
        OR tblstore.storeState LIKE :search 
        OR tblstore.storeCity LIKE :search 
        OR tblstore.vtype LIKE :search
        OR tbltype.VoucherType LIKE :search";
$query = $dbh -> prepare($sql);
$searchdata = '%'.$searchdata.'%';
$query->bindParam(':search', $searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

<div class="w-full md:w-1/3 px-4 mb-8">
<div class="voucher-list w-3/4 mb-20 p-5">
<a href="store-details.php?vhid=<?php echo htmlentities($result->id);?>"><div class="car-info-box flex items-center justify-center"><img src="admin/img/voucherimages/<?php echo htmlentities($result->logoStore);?>" class="img-responsive w-2/3" alt="image">
</div>
<div class="car-title-m mt-3">
<h3 class="text-black font-bold font-5xl" style="font-size:18px"><?php echo htmlentities($result->NameStore);?></h3>
<h3 class="text-gray-500 font-normal italic font-5xl" style="font-size:14px"><?php echo htmlentities($result->storeCity);?>,</h3>
<h3 class="text-gray-500 font-normal italic" style="font-size:14px"><?php echo htmlentities($result->storeState);?></h3>
</div></a>
</div>
</div>          


      <?php }} ?>
      
         </div>
            </div> 
      
     
    </div>
  </div>
</section>
<?php include('includes/modal.php');?>

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
