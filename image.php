
<style>
    .container1 {
  width: 100%;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  -webkit-perspective: 1000;
          perspective: 1000;
  position: relative;
}

.map {
  width: 350px;
  height: 350px;
  margin: 0 -50px;
  position: relative;

  background-size: cover;
  background-position: center;
  border-radius: 5px;
  -webkit-transition: .3s;
  transition: .3s;
  cursor: pointer;
}
.map:hover {
  -webkit-transition: .3s;
  transition: .3s;
  -webkit-transform: translateZ(5px) translateY(-20px) scale(1.1);
          transform: translateZ(5px) translateY(-20px) scale(1.1);
}

.map-1,
.map-4 {
  -webkit-transform: translateZ(1px);
          transform: translateZ(1px);
}

.map-2,
.map-5 {
  -webkit-transform: translateZ(2px) translateY(-5px);
          transform: translateZ(2px) translateY(-5px);
}

.map-3 {
  -webkit-transform: translateZ(3px) translateY(-10px);
          transform: translateZ(3px) translateY(-10px);
}

.map-1:hover ~ .map-2 {
  -webkit-transform: translateZ(4px) translateY(-15px);
          transform: translateZ(4px) translateY(-15px);
  -webkit-transition: .3s;
  transition: .3s;
}

.map-4 {
  -webkit-box-ordinal-group: 6;
      -ms-flex-order: 5;
          order: 5;
}
.map-4:hover ~ .map-5 {
  -webkit-transform: translateZ(3px) translateY(-15px);
          transform: translateZ(3px) translateY(-15px);
  -webkit-transition: .3s;
  transition: .3s;
}

</style>
<div class='container1'>
<?php

    $stmt = $dbh->prepare("SELECT * FROM tbllogo ORDER BY id DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $imageURL = 'admin/img/bannerimages/' . $row["Limage1"];
            ?>
            <div class="map map-2" style="background-image:url('<?php echo $imageURL; ?>')">
            </div>
            <?php
        }
    }
    ?>
</div>



