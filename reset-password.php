<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>InggitMalaysia | Reset Password</title>

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
    </div>
  </div>
</section>

<section class="listing-page" style="min-height:700px;">
  <div class="container ">
  <h1 class="text-center text-5xl font-bold mb-20">Reset Your Password</h1>
    <div class="row">
 
 <?php
session_start();
if (isset($_GET['key']) && isset($_GET['email'])) {
    $key = $_GET['key'];
    $email = $_GET['email'];

    $stmt = $dbh->prepare('SELECT * FROM password_reset_temp WHERE email = :email and tempkey = :key');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':key', $key);
    $stmt->execute();
    $results=$stmt->fetchAll(PDO::FETCH_OBJ);

    if ($stmt->rowCount() != 1) {
        $message[]= "This url is invalid or already been used. Please verify and try again.";
        exit;
    }
} else {
    header('location:index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newpassword=md5($_POST['newpassword']);

        //destroy the key from table
        $query = $dbh->prepare("DELETE FROM password_reset_temp WHERE email = :email and tempkey = :key");
        $query->bindParam(':email', $email);
        $query->bindParam(':key', $key);
        $query->execute();

        //update password in database
        $stmt2 = $dbh->prepare("UPDATE tblusers SET Password = :password WHERE EmailId = :email");
        $stmt2->bindParam(':password', $newpassword);
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();

        $message[] = "New password has been set for " . $email;

    } else {
      
       
    }

?>
 <style>
 .shadow-box {
  box-shadow: 1px 4px 8px rgba(0, 0, 0, 0.1); /* Adjust values as needed */
}
</style>

<div class="container">  
    <div class="table-responsive">  
    <br/>
    <br/>
 <div class="flex justify-center align-center">
    <div class="col-md-5 shadow-box p-10">
     <form name="chngpwd" onSubmit="return valid();" method="post" >  
      <input type="hidden" name="email" value="<?php echo $email; ?>"/>
      <div class="form-group">
       <label for="pwd">New Password</label>
       <input type="password" id="pwd" name="newpassword" placeholder="Enter Password" required 
       data-parsley-type="pwd" data-parsley-trigg
       er="keyup" class="form-control"/>
      </div>
      <div class="form-group">
       <label for="cpwd">Confirm Password</label>
       <input type="password" id="pwd" name="confirmpassword" placeholder="Enter Confirm Password" required data-parsley-type="cpwd" data-parsley-trigg
       er="keyup" class="form-control"/>
      </div>
      <div class="form-group">
       <input type="submit"  value="Reset Password" class="btn btn-block" />
       </div>
       
       
       <p class="text-center">This link will work only once for a limited time period.</p>
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
