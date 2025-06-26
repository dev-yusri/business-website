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
$namestore=filter_var(trim($_POST['namestore']), FILTER_SANITIZE_STRING);
$vtype=filter_var(trim($_POST['vtype']), FILTER_SANITIZE_STRING);
$storewebsite=filter_var(trim($_POST['storewebsite']), FILTER_SANITIZE_STRING);
$contactno=$_POST['contactno'];
$tagline=filter_var(trim($_POST['tagline']), FILTER_SANITIZE_STRING);
$operationhour=filter_var(trim($_POST['operationhour']), FILTER_SANITIZE_STRING);
$storestate=filter_var(trim($_POST['storestate']), FILTER_SANITIZE_STRING);
$storecity=filter_var(trim($_POST['storecity']), FILTER_SANITIZE_STRING);
$sdescription=filter_var(trim($_POST['sdescription']), FILTER_SANITIZE_STRING);
$id=intval($_GET['id']);

$sql="UPDATE tblstore SET NameStore=:namestore,vtype=:vtype,storeWebsite=:storewebsite,contactNo=:contactno,Tagline=:tagline,operationHour=:operationhour,storeState=:storestate,storeCity=:storecity,sdescription=:sdescription WHERE id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':namestore',$namestore,PDO::PARAM_STR);
$query->bindParam(':vtype',$vtype,PDO::PARAM_STR);
$query->bindParam(':storewebsite',$storewebsite,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->bindParam(':tagline',$tagline,PDO::PARAM_STR);
$query->bindParam(':operationhour',$operationhour,PDO::PARAM_STR);
$query->bindParam(':storestate',$storestate,PDO::PARAM_STR);
$query->bindParam(':storecity',$storecity,PDO::PARAM_STR);
$query->bindParam(':sdescription',$sdescription,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Store updated successfully";


}


	?>

<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_store.php",
data:'namestore='+$("#namestore").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

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

	<!-- Font awesome -->
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
$sql ="SELECT tblstore.*, tbltype.VoucherType, tbltype.id as bid FROM tblstore JOIN tbltype ON tbltype.id = tblstore.vtype WHERE tblstore.id = :id";
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
<label class="col-sm-2 control-label">Store Name<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="namestore" id="namestore" onBlur="checkAvailability()" class="form-control" value="<?php echo htmlentities($result->NameStore)?>" required>
</div>
<label class="col-sm-2 control-label">Select Type<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="vtype" required>
<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($bdname=$result->VoucherType); ?> </option>
<?php $ret="select id,VoucherType from tbltype";
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
<label class="col-sm-2 control-label">Store Website<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="storewebsite" class="form-control" value="<?php echo htmlentities($result->storeWebsite);?>" required>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">City<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="storecity" class="form-control" value="<?php echo htmlentities($result->storeCity);?>" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Contact No.<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="contactno" class="form-control" value="<?php echo htmlentities($result->contactNo);?>" required>
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
											
<div class="form-group">
<label class="col-sm-2 control-label">Tagline<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="tagline" class="form-control" value="<?php echo htmlentities($result->Tagline);?>" required>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Operation Hours<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="operationhour" class="form-control" value="<?php echo htmlentities($result->operationHour);?>" required>
</div>
</div>

<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-2 control-label">
<h4><b>Store Image</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4 control-label">
<img src="img/voucherimages/<?php echo htmlentities($result->logoStore);?>" width="200" height="200" style="border:solid 1px #000">
<br>
<a  href="changelogo.php?imgid=<?php echo htmlentities($result->id)?>"><h4 class="text-2xl">Change Logo of Stores</h4></a>
</div>



<div class="form-group">
<div class="col-sm-4 control-label">
<img src="img/voucherimages/<?php echo htmlentities($result->promoImg);?>" width="200" height="200" style="border:solid 1px #000">
<br>
<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>"><h4 class="text-2xl">Change Image of Stores</h4></a>
</div>
</div>


<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Promotion's Description<span style="color:red">*</span></label>
<div class="col-sm-8">
<textarea id="sdescription" name="sdescription" id="pgedetails" class="form-control" rows="5" cols="50"><?php echo htmlentities($result->sdescription);?></textarea>
</div>
</div>


<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2" >
													
<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
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

	<!-- Loading Scripts -->
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