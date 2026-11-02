<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo "Please login first!";
    exit();
}

$user_id = $_SESSION["user_id"];
$job_id = $_POST["job_id"];

$checkQuery = "SELECT id FROM saved_jobs
               WHERE user_id='$user_id'
               AND job_id='$job_id'";

$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {

    echo "Job already saved!";

} else {

    $sql = "INSERT INTO saved_jobs (user_id, job_id)
            VALUES ('$user_id', '$job_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Job saved successfully!";
    } else {
        echo "Save failed: " . mysqli_error($conn);
    }
}

?>