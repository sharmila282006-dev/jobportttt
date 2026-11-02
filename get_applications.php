<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {

    echo json_encode([]);

    exit();

}

$user_id = $_SESSION["user_id"];

$sql = "SELECT 
            applications.id,
            applications.resume,
            applications.status,
            applications.applied_at,
            jobs.title,
            jobs.company,
            jobs.location,
            users.name,
            users.email,
            users.phone
        FROM applications
        JOIN jobs 
        ON applications.job_id = jobs.id
        JOIN users
        ON applications.user_id = users.id
        WHERE applications.user_id='$user_id'
        ORDER BY applications.applied_at DESC";

$result = mysqli_query($conn, $sql);

$applications = [];

while ($row = mysqli_fetch_assoc($result)) {

    $applications[] = $row;

}

echo json_encode($applications);

?>