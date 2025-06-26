<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
include("config.php");
session_start();


if(isset($_POST['signup']))
{
$fname=$_POST['fullname'];
$email=$_POST['email']; 
$city=$_POST['city'];
$ustate=$_POST['ustate'];
$password=md5($_POST['password']); 
$otp= mt_rand(100000, 999999);	

$ret="SELECT id FROM  tblusers where (emailId=:uemail)";
$queryt = $dbh -> prepare($ret);
$queryt->bindParam(':uemail',$email,PDO::PARAM_STR);
$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
if($queryt -> rowCount() == 0)
{
  $emailverifiy=0;
$sql="INSERT INTO  tblusers(FullName,EmailId,City,uState,Password,emailOtp,isEmailVerify) VALUES(:fname,:emaill,:city,:ustate,:password,:otp,:isactive)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':emaill',$email,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':ustate',$ustate,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':otp',$otp,PDO::PARAM_STR);
$query->bindParam(':isactive',$emailverifiy,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{ 
  $_SESSION['emailid']=$email;

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
            
            echo "<script>window.location.href='../verify-otp.php'</script>";
  }else {
    $message[]="<span class='text-2xl'>Something went wrong.Please try again.";	
  }} else{
  $message[]="<span class='text-2xl'>Email id already assicated with another account</span>";
  }
  }


?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | Register</title>

<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="../assets/css/style.css" type="text/css">
<link rel="stylesheet" href="../assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="../assets/css/owl.transitions.css" type="text/css">
<link rel="stylesheet" type="text/css" href="../assets/css/slick.css"/>
<link rel="stylesheet" type="text/css" href="../assets/css/slick-theme.css"/>
<link href="../assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k79sMmlM/XWtDeanhTJguD1mSpVVnu16Oa7KqG6QR8FkTmatlrMfj7meaQ9P35h6yKr6iM0/JuRoZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/slick.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<script type="text/javascript">
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>        
</head>
<body>
  <style>
.shadow-box {
  box-shadow: 1px 4px 8px rgba(0, 0, 0, 0.1); /* Adjust values as needed */
}
</style>

<section class="page-header listing_page">
  <div class="container flex items-center justify-start">
  <div class="navbar-header  ">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="../index.php"><h1 class="white-text font-semibold text-4xl">InggitMalaysia</h1></a>
      </div>
    <div class="page-header_wrap">
      <div class="page-heading">
      
    </div>
  </div>
</section>

<section class="listing-page" style="min-height:800px;">
  <div class="container">
  <h1 class="text-4xl font-semibold mt-10 mb-10 text-center">Register Account</h1>
    <div class="row">
    <div class="container ">  
    <div class="table-responsive">  
    <br/>
    <br/>
 <div class="flex justify-center align-center">
    <div class="col-md-5 shadow-box p-10">
    <div class="form-header ">
</div>

              <form  method="post" name="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Full Name" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="emailid" onBlur="checkAvailability()" placeholder="Email Address" required="required">
                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                      <div class="form-group">
                  <input type="text" class="form-control" name="city" placeholder="City" required="required">
                </div>
                      <div class="form-group">
                  <input type="text" class="form-control" name="ustate" placeholder="State" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="text-center">
        <p>Already got an account? <a href="../index.php#loginform" >Login Here</a></p>
      </div>

<?php include('modal.php'); ?>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script> 
<script src="../assets/js/interface.js"></script> 
<script src="../assets/switcher/js/switcher.js"></script>
<script src="../assets/js/bootstrap-slider.min.js"></script> 
<script src="../assets/js/slick.min.js"></script> 
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/confirmps.js"></script>
