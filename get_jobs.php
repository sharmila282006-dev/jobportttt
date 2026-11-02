<?php
include "db.php";

$sql = "SELECT * FROM jobs";
$result = mysqli_query($conn, $sql);

$jobs = [];

while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}

echo json_encode($jobs);
?>