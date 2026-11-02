<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT id, message, created_at
        FROM notifications
        WHERE user_id='$user_id'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

$notifications = [];

while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}

echo json_encode($notifications);

?>