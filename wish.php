<?php 
session_start();

$email = $_SESSION['login'];
$_SESSION['voucher_title'] = $voucher;

$select_cart = $dbh->prepare("SELECT * FROM tbladdwish WHERE VoucherTitle = :voucher_title AND userEmail = :userId");
$select_cart->bindParam(':voucher_title', $_SESSION['voucher_title']); // Use single quotes consistently
$select_cart->bindParam(':userId', $email);
$select_cart->execute();

if ($select_cart->rowCount() > 0) {
    echo '<i class="fa fa-heart mr-5 text-5xl text-red-500 hover:text-blue-500" aria-hidden="true"></i>';
} else {
    echo '<i class="fa fa-heart-o mr-5 text-5xl text-red-500 hover:text-blue-500" aria-hidden="true"></i>';
}
?>

