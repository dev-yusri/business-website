<?php 
require_once("includes/config.php");

if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];

		$sql ="SELECT VoucherTitle FROM tblvoucher WHERE VoucherTitle=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Voucher name already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>