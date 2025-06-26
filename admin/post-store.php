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
$namestore=$_POST['namestore'];
$vtype=$_POST['vtype'];
$storewebsite=$_POST['storewebsite'];
$contactno=$_POST['contactno'];
$tagline=$_POST['tagline'];
$storecity=$_POST['storecity'];
$storestate=$_POST['storestate'];
$operationhour=$_POST['operationhour'];
$sdescription=$_POST['sdescription'];
$logostore=$_FILES["logostore"]["name"];
move_uploaded_file($_FILES["logostore"]["tmp_name"],"img/voucherimages/".$_FILES["logostore"]["name"]);
$promoimg=$_FILES["promoimg"]["name"];
move_uploaded_file($_FILES["promoimg"]["tmp_name"],"img/voucherimages/".$_FILES["promoimg"]["name"]);

$sql="INSERT INTO tblstore(NameStore,vtype,storeWebsite,contactNo,Tagline,storeCity,storeState,operationHour,sdescription,logoStore,promoImg) VALUES(:namestore,:vtype,:storewebsite,:contactno,:tagline,:storecity,:storestate,:operationhour,:sdescription,:logostore,:promoimg)";
$query = $dbh->prepare($sql);
$query->bindParam(':namestore',$namestore,PDO::PARAM_STR);
$query->bindParam(':vtype',$vtype,PDO::PARAM_STR);
$query->bindParam(':storewebsite',$storewebsite,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->bindParam(':tagline',$tagline,PDO::PARAM_STR);
$query->bindParam(':storecity',$storecity,PDO::PARAM_STR);
$query->bindParam(':storestate',$storestate,PDO::PARAM_STR);
$query->bindParam(':operationhour',$operationhour,PDO::PARAM_STR);
$query->bindParam(':sdescription',$sdescription,PDO::PARAM_STR);
$query->bindParam(':logostore',$logostore,PDO::PARAM_STR);
$query->bindParam(':promoimg',$promoimg,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Store has been added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

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
	
	<title>InggitMalaysia | Admin Add Store</title>

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
					
						<h2 class="page-title">Add a Store</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return valid();">
<div class="form-group">
<label class="col-sm-2 control-label">Store Name<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="namestore" id="namestore" onBlur="checkAvailability()" class="form-control" required>
<span id="user-availability-status" style="font-size:12px;"></span> 
</div>
<label class="col-sm-2 control-label">Select Type<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="vtype" required>
<option value=""> Select </option>
<?php $ret="select id,VoucherType from tbltype";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $result)
{ 
?>
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->VoucherType);?></option>
<?php }} ?>

</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Store's Website<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="storewebsite" class="form-control" required>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">City<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="storecity" class="form-control" required>
</div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Contact No.<span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="text" name="contactno" class="form-control" required>
  </div>


<div class="form-group">
<label class="col-sm-2 control-label">State<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="storestate" required>
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
    <input type="text" name="tagline" class="form-control" required>
  </div>

<div class="form-group">
<label class="col-sm-2 control-label">Operation Hours<span style="color:red">*</span></label>
<div class="col-sm-2">
<input type="text" name="operationhour" class="form-control" required>
</div>
</div>
<div class="hr-dashed"></div>


<div class="form-group">
<div class="col-sm-3 control-label">
<h4><b>Upload Store Logo</b></h4>
</div>
<div class="col-sm-2">
Max file size: 5mb<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input id="inp" type="file" accept="image/*" name="logostore" required></div>
</div>
</div>
</div>

<div class="form-group">
<div class="col-sm-3 control-label">
<h4><b>Upload Store Promotion Image</b></h4>
</div>
<div class="col-sm-2">
Max file size: 5mb<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input id="inp" type="file" accept="image/*" name="promoimg" required></div>
</div>
</div>

								
</div>
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-3 control-label">Promotion's Description<span style="color:red">*</span></label>
<div class="col-sm-8">
<textarea id="sdescription" name="sdescription" class="form-control" rows="5" cols="50"></textarea>
<div class="hr-dashed"></div>
</div>
</div>
</div>
</div>
</div>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2 mx-auto">
													<button class="btn btn-default"  type="reset">Cancel</button>
													<button class="btn btn-primary" name="submit" id="submit" type="submit">Save changes</button>
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
	<script src="js/imagesize.js"></script>
</body>
</html>
<?php } ?>