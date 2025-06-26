<?php session_start();
include_once('includes/config.php');
error_reporting(0);
 

if($_SESSION['emailid']=='' ){
echo "<script>window.location.href='index.php'</script>";
}else{
 

if(isset($_POST['verify'])){
  
$emailid=$_SESSION['emailid'];	
$otp=$_POST['emailotp'];	

$stmt=$dbh->prepare("SELECT emailOtp FROM  tblusers where EmailId=:emailid");
$stmt->execute(array(':emailid'=>$emailid)); 
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
$dbotp=$row['emailOtp'];
}
if($dbotp!=$otp){
echo "<script>alert('Please enter correct OTP');</script>";	
} else {
$emailverifiy=1;
$sql="update tblusers set isEmailVerify=:emailverifiy where EmailId=:emailid";
$query = $dbh->prepare($sql);
$query->bindParam(':emailid',$emailid,PDO::PARAM_STR);
$query->bindParam(':emailverifiy',$emailverifiy,PDO::PARAM_STR);
$query->execute();
session_destroy();
$message[]= "<span style='font-size:14px;'>Your account successfully verified. Now you can login.</span>";

echo "<script>window.location.href='index.php'</script>";

}}
}
 
?>
 <style>
 .shadow-box {
  box-shadow: 1px 4px 8px rgba(0, 0, 0, 0.1); 
}
</style>
<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | Email Verify</title>

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

<section class="page-header listing_page">
  <div class="container flex items-center justify-start">
  <div class="navbar-header  ">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="index.php"><h1 class="white-text font-semibold text-4xl">InggitMalaysia</h1></a>
      </div>
    <div class="page-header_wrap">
      <div class="page-heading">
    </div>
  </div>
</section>

<section class="listing-page" style="min-height:700px;">
  <div class="container">
  <h1 class="text-4xl font-bold text-center">Email OTP Verification</h1>
  <p class="text-s text-gray-400 font-thin text-center">Check your email</p>
    <div class="row">
    <div class="container ">  
    <div class="table-responsive">  
    <br/>
    <br/>
 <div class="flex justify-center align-center">
    <div class="col-md-5 shadow-box p-10">
    <form method="post" action="">
    <div class="form-header ">
</div>
<div class="form-group">
<label>Email OTP</label>
<input type="text" class="form-control text-center" name="emailotp" maxlength="6" required="required">

</div>
 
<div class="form-group">
<button type="submit" class="btn btn-primary btn-block" name="verify">Verify</button>
<p class="text-center mt-5"> <a class="text-gray-500" href="resend-otp.php">Resend OTP</a></p>
</div>

</form>
       
       
       <br><br>
                <p class="text-center"> <a href="index.php">Back to Login</a></p>
                <br>
     </form>
     </div>
   </div>  
  </div>



</div>
</div>

</section>
<?php include('includes/modal1.php');?>

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
<script src="assets/js/confirmps.js"></script>
</body>
</html>