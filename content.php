<?php
include 'includes/config.php';

$sql = "SELECT * FROM tblstore WHERE NameStore LIKE :search OR storeCity LIKE :search";
$stmt = $conn->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output = " 
                    <tr>
                    <td>" . htmlspecialchars($row['NameStore']) . "</td>
                   </tr>";
        echo $output;
    }
} else {
    echo "<tr><td>No data found!</td></tr>";
}
?>