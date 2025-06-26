<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['submit']))
  {
$vouchertitle=filter_var(trim($_POST['vouchertitle']), FILTER_SANITIZE_STRING);
$vouchertype=filter_var(trim($_POST['vouchertype']), FILTER_SANITIZE_STRING);
$namestore=filter_var(trim($_POST['namestore']), FILTER_SANITIZE_STRING);
$discount=$_POST['discount'];
$voucherduration=$_POST['voucherduration'];
$tagline=filter_var(trim($_POST['tagline']), FILTER_SANITIZE_STRING);
$storestate=filter_var(trim($_POST['storestate']), FILTER_SANITIZE_STRING);
$storecity=filter_var(trim($_POST['storecity']), FILTER_SANITIZE_STRING);
$ispopular=filter_var(trim($_POST['ispopular']), FILTER_SANITIZE_STRING);
$terms=filter_var(trim($_POST['terms']), FILTER_SANITIZE_STRING);
$payment=filter_var(trim($_POST['paymenttype']), FILTER_SANITIZE_STRING);
$id=intval($_GET['id']);

$sql="UPDATE tblvoucher SET VoucherTitle=:vouchertitle,VoucherType=:vouchertype,NameStore=:namestore,Discount=:discount,voucherEnd=:voucherduration,Tagline=:tagline,storeState=:storestate,storeCity=:storecity,isPopular=:ispopular,TermsC=:terms,PaymentType=:paymenttype WHERE id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':vouchertitle',$vouchertitle,PDO::PARAM_STR);
$query->bindParam(':vouchertype',$vouchertype,PDO::PARAM_STR);
$query->bindParam(':namestore',$namestore,PDO::PARAM_STR);
$query->bindParam(':discount',$discount,PDO::PARAM_STR);
$query->bindParam(':voucherduration',$voucherduration,PDO::PARAM_STR);
$query->bindParam(':tagline',$tagline,PDO::PARAM_STR);
$query->bindParam(':storestate',$storestate,PDO::PARAM_STR);
$query->bindParam(':storecity',$storecity,PDO::PARAM_STR);
$query->bindParam(':ispopular',$ispopular,PDO::PARAM_STR);
$query->bindParam(':terms',$terms,PDO::PARAM_STR);
$query->bindParam(':paymenttype',$payment,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Voucher updated successfully";


}


	?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>InggitMalaysia | Admin Edit Stores</title>

	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/textarea.js"></script>
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
	<style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>
</head> 

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edit Stores</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php 
$id=intval($_GET['id']);
$sql ="SELECT tblvoucher.*,tblstore.id,tblstore.NameStore,tbltype.VoucherType,tbltype.id as bid FROM tblvoucher LEFT OUTER JOIN tblstore ON tblstore.id = tblvoucher.NameStore JOIN tbltype ON tbltype.id = tblvoucher.VoucherType WHERE tblvoucher.id = :id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?> 


<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="form-group">
<div class="col-sm-2 control-label">
<h4><b>Voucher Image</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4 control-label">
<img src="img/voucherimages/<?php echo htmlentities($result->Vimage1);?>" width="200" height="200" style="border:solid 1px #000">
<br>
<a href="changeimgvoucher.php?imgid=<?php echo htmlentities($result->id)?>"><h4 class="text-2xl">Change Image of Voucher</h4></a>
</div>
</div>

<br>
<div class="form-group">
<label class="col-sm-2 control-label">Voucher Name<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vouchertitle" class="form-control" value="<?php echo htmlentities($result->VoucherTitle)?>" required>
</div>

<label class="col-sm-2 control-label">Select Type<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="vouchertype" required>
<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($bdname=$result->VoucherType); ?> </option>
<?php $ret="select VoucherType from tbltype";
$query= $dbh -> prepare($ret);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->VoucherType==$bdname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->VoucherType);?></option>
<?php }}} ?>

</select>
</div>
</div>									
<div class="form-group">
<label class="col-sm-2 control-label">Store Name<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="namestore" required>
<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($bdname=$result->NameStore); ?> </option>
<?php $ret="select NameStore from tblstore";
$query= $dbh -> prepare($ret);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->NameStore==$bdname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->NameStore);?></option>
<?php }}} ?>

</select>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Discount<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="discount" class="form-control" value="<?php echo htmlentities($result->Discount);?>" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Description<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="tagline" class="form-control" value="<?php echo htmlentities($result->Tagline);?>" required>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">City<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="storecity" class="form-control" value="<?php echo htmlentities($result->storeCity);?>" required>
</div>
</div>
											
<div class="form-group">
<label class="col-sm-2 control-label">Voucher End Date<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="date" name="voucherduration" class="form-control" value="<?php echo htmlentities($result->voucherEnd);?>" required>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">State<span style="color:red">*</span></label>
<div class="col-sm-2">
<select class="selectpicker" name="storestate" required>
<option value="<?php echo htmlentities($result->storeState);?>"> <?php echo htmlentities($result->storeState);?> </option>

<option value=""> Select </option>
<option value="Johor">Johor</option>
<option value="Kedah">Kedah</option>
<option value="Kuala Lumpur">Kuala Lumpur</option>
<option value="Malacca">Malacca</option>
<option value="Negeri Sembilan">Negeri Sembilan</option>
<option value="Pahang">Pahang</option>
<option value="Penang">Penang</option>
<option value="Perak">Perak</option>
<option value="Perlis">Perlis</option>
<option value="Sabah">Sabah</option>
<option value="Sarawak">Sarawak</option>
<option value="Selangor">Selangor</option>
<option value="Terengganu">Terengganu</option>
<option value="Putrajaya">Putrajaya</option>

</select>
</div>
</div>
</div>



<div class="form-group">
<label class="col-sm-2 control-label">Is popular? <span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="ispopular" required>
<option value="<?php echo htmlentities($result->isPopular);?>"> <?php echo htmlentities($result->isPopular);?> </option>

<option value=""> Select </option>
<option value="Yes">Yes</option>
<option value="No">No</option>

</select>
</div>

<label class="col-sm-2 control-label">Payment Type <span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="paymenttype" required>
<option value="<?php echo htmlentities($result->PaymentType);?>"> <?php echo htmlentities($result->PaymentType);?> </option>

<option value=""> Select </option>
<option value="Inhouse">Inhouse</option>
<option value="Credit">Credit</option>

</select>
</div>
</div><br><br>
<div class="form-group">
<label class="col-sm-2 control-label">Terms & Condition<span style="color:red">*</span></label>
<div class="col-sm-9">
<textarea name="terms" class="form-control" rows="5" cols="100"><?php echo htmlentities($result->TermsC);?></textarea>
<div class="hr-dashed"></div>
</div>
</div>

<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2" >
													
<button class="btn btn-primary" name="submit" type="submit" id="update-button" style="margin-top:4%">Save changes</button>
												</div>
											</div>

										</form>
									</div>
								</div>
							</div>
						</div>
						
					

					</div>
				</div>
				
			

			</div>
		</div>
	</div>


	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>