<?php session_start();
include_once('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['resend'])){

$email=$_POST['email'];	
$otp= mt_rand(100000, 999999);	

$ret="SELECT id,isEmailVerify FROM  tblusers where (EmailId=:uemail)";
$queryt = $dbh -> prepare($ret);
$queryt->bindParam(':uemail',$email,PDO::PARAM_STR);
$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
if($queryt -> rowCount() > 0)
{
foreach ($results as $result) {
$verifystatus=$result->isEmailVerify;}	
 
if($verifystatus=='1'){
$message[]= "<span style='font-size:14px;'>Email already verified. No need to verify again.</span>";
} else{
$_SESSION['emailid']=$email;
$_SESSION['otp']=$otp;
 
$sql="update tblusers set emailOtp=:otp where EmailId=:emailid";
$query = $dbh->prepare($sql);

$query->bindParam(':emailid',$email,PDO::PARAM_STR);
$query->bindParam(':otp',$otp,PDO::PARAM_STR);
$query->execute();	
$mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "mrking9909@gmail.com";
            $mail->Password = "hwjlbokhnhrztbcx";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
          
            $mail->setFrom('mrking9909@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true); 
            $mail->Subject ="OTP Verification";
            $mail->Body ="<div style='padding-top:8px;'>Thank you for registering with us. OTP for Account Verification is <br>
            <p style='text-align:center; font-size:26px;'>". $otp."</p></div>";
            $mail->send();
            echo "<script>alert('<span style='font-size:12px;'>Check your email for OTP number.</span>');</script>";
            echo "<script>window.location.href='verify-otp.php'</script>";

}}else {
$message[]= "Email id not registered yet.";
}
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

<section class="listing-page" style="min-height:800px;">
  <div class="container">
  <h1 class="text-4xl font-semibold mt-10 mb-10 text-center">Resend OTP</h1>
    <div class="row">
    <div class="container ">  
    <div class="table-responsive">  
    <br/>
    <br/>
 <div class="flex justify-center align-center">
    <div class="col-md-5 shadow-box p-10">
    <div class="form-header ">
</div>

              <form  method="post" >
              <div class="form-group">
<label class="font-semibold">Email Address</label>
<input type="email" class="form-control" name="email" placeholder="Enter Your Email" required="required">
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-block" name="resend">Resend</button>
</div>	
</form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="text-center">
        <p>Already got an account? <a href="index.php#loginform" >Login Here</a></p>
      </div>

<?php include('includes/modal.php'); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/confirmps.js"></script>