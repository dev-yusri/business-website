
  <style>
 
/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media screen and (max-width: 500px) {
    .column {
        width: 100%;
    }
}
.thumbnail img{
    max-width: 100%; /* do not stretch the bootstrap column */
}

.img-wrapper{
	width: 100%;
	padding-bottom: 100%; /* your aspect ratio here! */
	position: relative;
}

.img-wrapper img{
	position: absolute;
	top: 0; 
	bottom: 0; 
	left: 0; 
	right: 0;
	min-height: 50%;
	max-height: 100%;
	min-width:100%/* optional: if you want the smallest images to fill the .thumbnail */
}
</style>

<body>

<div class="container">
  <form action="" method="post">
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <select class="form-control" name="category">
            <option value="">Select Payment Type</option>
            <option value="Inhouse">Inhouse</option>
            <option value="Credit">Credit</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Apply</button>
    </div>
  </form>
</div>

<div class="container-fluid">
  <?php
  error_reporting(error_reporting() & ~E_NOTICE);

  if (isset($_POST['category'])) {
      $category = $_POST['category'];

      include 'includes/config.php';

      try {
        
          $qry = "SELECT tblvoucher.VoucherTitle, tbltype.VoucherType, tblvoucher.Discount, tblvoucher.Tagline, tblstore.NameStore, tblvoucher.id, tblvoucher.Vimage1, tblvoucher.voucherEnd, tblvoucher.TermsC
		  FROM tblvoucher
		  JOIN tbltype ON tbltype.id = tblvoucher.VoucherType
		  JOIN tblstore ON tblstore.id = tblvoucher.NameStore
		  WHERE tblvoucher.voucherEnd >= CURDATE() AND tblvoucher.PaymentType = :category";
          $statement = $dbh->prepare($qry);
          $statement->bindParam(':category', $category, PDO::PARAM_STR);
          $statement->execute();

          $num = $statement->rowCount();

          if ($num > 0) {
              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <!-- item -->
          <div class="col-xs-5 col-sm-3">
            <div class=" voucher-list p-5">
			<a href="#terms_<?php echo $row['id'];?>"  data-toggle="modal" data-dismiss="modal">
              <div class="img-wrapper">
                <img src="admin/img/voucherimages/<?php echo $row['Vimage1'];?>"  class="w-2/3" alt="400">
              </div>
			  <div class="car-title-m ">
          <h4 class="text-gray-500 font-bold" style="font-size:16px"><?php echo $row['VoucherType'];?></h4>
          <h4 class="text-blue-600 font-normal  mb-2" style="font-size:16px"><a href="store-details.php?sname=<?php echo $row['NameStore'];?>"><?php echo $row['NameStore'];?></a></h4>
          <h4 class="text-black font-bold font-6xl" style="font-size:20px"><?php echo $row['VoucherTitle'];?></h4>
          <h4 class="text-black  font-normal" style="font-size:16px">Up to <?php echo $row['Discount'];?> %!</h4>
          <h4 class="text-black font-normal" style="font-size:16px"><?php echo $row['Tagline'];?></h4>
			  </a>
		  <div class="modal" id="terms_<?php echo $row['id'];?>" >
        <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title flex justify-center align-center font-bold">Terms and Condition</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="">
            <div class="p-5" style="overflow:scroll; height:300px;">
            <p><?php echo $row['TermsC'];?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
</div>

<br>
<ul class="flex pl-0" style="float:left">
  <li><?php if($_SESSION['login']){?>
    <input type="hidden" name="voucher_image" value="<?php echo htmlentities($result->Vimage1);?>">
         <input type="hidden" name="voucher_type" value="<?php echo htmlentities($result->VoucherType);?>">
         <input type="hidden" name="voucher_store" value="<?php echo htmlentities($result->NameStore);?>">
         <input type="hidden" name="voucher_title" value="<?php echo htmlentities($result->VoucherTitle);?>">
         <input type="hidden" name="voucher_discount" value="<?php echo htmlentities($result->Discount);?>">
         <input type="hidden" name="voucher_tagline" value="<?php echo htmlentities($result->Tagline);?>">
         <input type="hidden" name="voucher_duration" value="<?php echo htmlentities($result->voucherEnd);?>">
    <button type="submit" name="add_to_cart">
              <i class="fa fa-heart-o mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> 
  </button>


            </li>
            <?php } else { ?>
                <li><a href="#loginform" class="login_btn" data-toggle="modal" data-dismiss="modal"> <i class="fa fa-heart-o mr-5 text-4xl text-red-500 hover:text-blue-500" aria-hidden="true"></i> </a></li>
                <?php } ?></li>
  <li><div class="countdown" data-id="<?php echo $row['id'];?>" data-end="<?php echo (new DateTime($row['voucherEnd']))->format('Y-m-d H:i:s'); ?>">
  <div class=" text-white bg-red-500 inline-block p-1" style="font-size:10px;"><a class="countdown-item" data-id="days"></a> days left</div>
            <div class="countdown-item" data-id="hours" style="display:none">00</div>
            <div class="countdown-item" data-id="minutes" style="display:none">00</div>
            <div class="countdown-item" data-id="seconds" style="display:none">00</div>
        </div></li>
            </form>            
</ul>
            </div>
			  </div>
          </div>
          <?php
              }
          } else {
              echo "No results found.";
          }
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
  } else {
   
      echo "Please select a payment type.";
  }
  ?>
</div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var countdowns = document.querySelectorAll('.countdown');

        countdowns.forEach(function (countdown) {
            var id = countdown.dataset.id;
            var end = new Date(countdown.dataset.end);

            function updateClock() {
                var now = new Date();
                var t = end - now;

                if (t <= 0) {
                    countdown.innerHTML = "<h3>Expired</h3>";
                    clearInterval(timeinterval);
                    return;
                }

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                countdown.querySelector('.countdown-item[data-id="days"]').innerHTML = days;
                countdown.querySelector('.countdown-item[data-id="hours"]').innerHTML = hours;
                countdown.querySelector('.countdown-item[data-id="minutes"]').innerHTML = minutes;
                countdown.querySelector('.countdown-item[data-id="seconds"]').innerHTML = seconds;
            }

            var timeinterval = setInterval(updateClock, 1000);
            updateClock(); 
        });
    });
</script>