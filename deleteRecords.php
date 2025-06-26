<?php
include_once("includes/config.php");
if ($_REQUEST['empid']) {
    $stmt = $dbh->prepare("DELETE FROM tbladdwish WHERE id = :id");
    $stmt->bindParam(':id', $_REQUEST['empid'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "Record Deleted";
    }
}
?>