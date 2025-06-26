<?php
include 'includes/config.php';

$sql = "SELECT * FROM tblstore WHERE NameStore LIKE :search OR storeCity LIKE :search OR storeState LIKE :search";
$stmt = $dbh->prepare($sql);
$search = '%' . $_POST['search'] . '%';
$stmt->bindParam(':search', $search);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<p class='word'> Stores </p>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<a style='color:#000; ' href='store-details.php?vhid=" . htmlentities($row['id']) . "'><h6 class='user'>" . htmlspecialchars($row['NameStore']) . "<b style='float:right; color:gray; font-weight:400; font-size:20px; font-style: italic;'>" . htmlspecialchars($row['storeCity']) . ", ".htmlspecialchars($row['storeState']) ."</b></h6></a>";
    }
} else {
    echo "<p style='font-size:20px'> No stores or location found...</p>";
}