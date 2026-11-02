<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo "Please login first!";
    exit();
}

$user_id = $_SESSION["user_id"];
$job_id = $_POST["job_id"];

$sql = "DELETE FROM saved_jobs
        WHERE user_id='$user_id'
        AND job_id='$job_id'";

if (mysqli_query($conn, $sql)) {
    echo "Job removed successfully!";
} else {
    echo "Remove failed: " . mysqli_error($conn);
}

?>