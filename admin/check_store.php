<?php 
require_once("includes/config.php");

if(!empty($_POST["namestore"])) {
	$email= $_POST["namestore"];
		$sql ="SELECT NameStore FROM tblstore WHERE NameStore=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Store already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>
