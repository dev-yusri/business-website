<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Voucher List</title>
  <style>
    .grid-item {
      width: 200px;
      height: 200px;
      border: 1px solid black;
      display: inline-block;
      margin: 10px;
      position: relative;
    }
    .grid-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .grid-item .tag-expire {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 1;
      transition: opacity 0.5s ease-in-out;
    }
  </style>
</head>
<body>
  <div id="voucher-list">
    <?php
      
      $pdo = new PDO('mysql:host=localhost;dbname=inggitmy', 'root', '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM tblvoucher';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {

        $expiration_date = new DateTime();
        $expiration_date->modify('+' . $result->Voucherduration . ' days');
        $expiration_date_str = $expiration_date->format('Y-m-d');

        // Display the voucher
        echo '<div class="grid-item tag-expire' . $expiration_date_str . '">';
        echo '<img src="' . $result->Vimage1 . '" alt="' . htmlentities($result->VoucherTitle) . '">';
        echo '<a href="all-vouchers.php?id=' . $result->id . '">View Voucher</a>';
        echo '</div>';
      }
    ?>
  </div>

  <script type="text/javascript">
window.addEventListener('DOMContentLoaded', (event) => {
  var elements = document.getElementsByClassName('grid-item');
  for (var i = 0; i < elements.length; i++) {
      var ele = elements[i];
      if (ele.className.includes('tag-expire')) {
          var classes = ele.className.split(' ');
          for (var j = 0; j < classes.length; j++) {
              if (classes[j].includes('tag-expire')) {
                  var expireDate = new Date(classes[j].substring(10));
                  if (expireDate <= Date.now()) {
                      ele.style.display = 'none';
                      ele.getElementsByTagName('img')[0].style.display = 'none';
                      ele.getElementsByTagName('a')[0].style.display = 'none';
                  }
              }
          }
      }
  }
});
  </script>
</body>
</html>