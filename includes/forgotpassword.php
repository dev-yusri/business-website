<?php

include("includes/config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['reset'])) {
    $email_reg = $_POST['email'];
    $tkey = $_POST['key'];

    try {
        $stmt5 = $dbh->prepare("SELECT * FROM tblusers WHERE EmailId = :email");
        $stmt5->bindParam(':email', $email_reg);
        $stmt5->execute();
        $results = $stmt5->fetchAll(PDO::FETCH_OBJ);

        if ($stmt5->rowCount() > 0) { //if the given email is in database, ie. registered
            $message[] = "<span style='font-size:14px;'>We've sent you an email to recover your password.</span>";

            //generating the random key
            $key = md5(time() + 123456789 % rand(4000, 55000000));

            $stmt1_insert = $dbh->prepare("INSERT INTO password_reset_temp(email, tempkey) VALUES(:email, :key)");
            $stmt1_insert->bindParam(':email', $email_reg);
            $stmt1_insert->bindParam(':key', $key);
            $stmt1_insert->execute();

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "mrking9909@gmail.com";
            $mail->Password = "hwjlbokhnhrztbcx";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            // send by h-hotel email
            $mail->setFrom('mrking9909@gmail.com');
            $mail->addAddress($email_reg);

            $mail->isHTML(true);            
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Trouble signing in? <br>
            Resetting your password is easy.<br><br>
          
            Just press the button below and follow the instructions. We’ll have you up and running in no time.<br><br>" . "\r\n" . 
            "<a href= http://localhost/Inggit%20-%20test/reset-password.php?key=" . $key . "&email=" . $email_reg . "\r\n" . "><button type='button' style='color:white; padding:10px; background:blue; font-weight:800;'>Click Me</button></a>". "\r\n" .
            "<br><br><br>If you did not make this request then please ignore this email. <br><br><br>From: InggitMalaysia";

            $mail->send();
        } else  {
            $message[] = "Sorry! No account associated with this email";
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
?>

<head>

<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<div class="modal fade" id="forgotpassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Password Recovery</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="forgotpassword_wrap">
            <div class="col-md-12">
            <form id="validate_form" method="post" >  
                <div class="form-group">
                <input  class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Please Enter Your Email" >
                </div>

                <div class="form-group">
                  <input type="submit" name="reset" value="Send Password Reset Link" class="btn btn-block">
                </div>
              </form>
              <div class="text-center">
                <p class="gray_text">For security reasons we don't store your password. Your password link will be sent via email.</p>
                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back to Login</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/modal.php');?>
