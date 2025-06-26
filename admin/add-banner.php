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
$bimage1=$_FILES["bimage1"]["name"];
move_uploaded_file($_FILES["bimage1"]["tmp_name"],"img/bannerimages/".$_FILES["bimage1"]["name"]);
$bimage2=$_FILES["bimage2"]["name"];
move_uploaded_file($_FILES["bimage2"]["tmp_name"],"img/bannerimages/".$_FILES["bimage2"]["name"]);
$bimage3=$_FILES["bimage3"]["name"];
move_uploaded_file($_FILES["bimage3"]["tmp_name"],"img/bannerimages/".$_FILES["bimage3"]["name"]);
$bimage4=$_FILES["bimage4"]["name"];
move_uploaded_file($_FILES["bimage4"]["tmp_name"],"img/bannerimages/".$_FILES["bimage4"]["name"]);
$bimage5=$_FILES["bimage5"]["name"];
move_uploaded_file($_FILES["bimage5"]["tmp_name"],"img/bannerimages/".$_FILES["bimage5"]["name"]);

$sql="INSERT INTO tblbanner(Bimage1,Bimage2,Bimage3,Bimage4,Bimage5) VALUES(:bimage1,:bimage2,:bimage3,:bimage4,:bimage5)";
$query = $dbh->prepare($sql);
$query->bindParam(':bimage1',$bimage1,PDO::PARAM_STR);
$query->bindParam(':bimage2',$bimage2,PDO::PARAM_STR);
$query->bindParam(':bimage3',$bimage3,PDO::PARAM_STR);
$query->bindParam(':bimage4',$bimage4,PDO::PARAM_STR);
$query->bindParam(':bimage5',$bimage5,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Banner has been added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

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
	
	<title>InggitMalaysia | Admin Add Banner</title>

	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
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
					
						<h2 class="page-title">Add a Banner</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">


<div class="form-group">
<div class="col-sm-2 control-label">
<h4><b>Upload Banner</b></h4>
</div>
<div class="col-sm-2">
Banner 1<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input type="file" name="bimage1" required></div>
</div>
</div>


<div class="form-group">
<div class="col-sm-2 control-label">
</div>
<div class="col-sm-2">
Banner 2<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input type="file" name="bimage2" required></div>
</div>
</div>

<div class="form-group">
<div class="col-sm-2 control-label">
</div>
<div class="col-sm-2">
Banner 3<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input type="file" name="bimage3" required></div>
</div>
</div>

<div class="form-group">
<div class="col-sm-2 control-label">
</div>
<div class="col-sm-2">
Banner 2<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input type="file" name="bimage4" required></div>
</div>
</div>


<div class="form-group">
<div class="col-sm-2 control-label">
</div>
<div class="col-sm-2">
Banner 2<span style="color:red">*</span>
<div class="form-group">
<div class="col-sm-4">
<input type="file" name="bimage5" required></div>
</div>
</div>
								
</div>
<div class="hr-dashed"></div>
</div>
</div>
</div>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2 mx-auto">
													<button class="btn btn-default"  type="reset">Cancel</button>
													<button class="btn btn-primary" name="submit" type="submit">Save changes</button>
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