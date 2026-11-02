<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT 
            saved_jobs.id,
            jobs.id AS job_id,
            jobs.title,
            jobs.company,
            jobs.location,
            jobs.salary,
            jobs.experience
        FROM saved_jobs
        JOIN jobs
        ON saved_jobs.job_id = jobs.id
        WHERE saved_jobs.user_id='$user_id'
        ORDER BY saved_jobs.id DESC";

$result = mysqli_query($conn, $sql);

$jobs = [];

while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}

echo json_encode($jobs);

?>