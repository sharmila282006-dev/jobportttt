<?php

session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo "Please login first!";
    exit();
}

$user_id = $_SESSION["user_id"];

$job_title = $_POST["job_title"];

$jobQuery = "SELECT id FROM jobs WHERE title='$job_title' LIMIT 1";
$jobResult = mysqli_query($conn, $jobQuery);

if ($jobResult && mysqli_num_rows($jobResult) == 1) {

    $job = mysqli_fetch_assoc($jobResult);
    $job_id = $job["id"];

    // Check already applied
    $checkQuery = "SELECT id FROM applications
                   WHERE user_id='$user_id'
                   AND job_id='$job_id'";

    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        header("Location: myapplications.php");
        exit();
    }

    $resume = "";

    if (isset($_FILES["resume"]) && $_FILES["resume"]["name"] != "") {
        $resume = $_FILES["resume"]["name"];
    }

    $status = "Under Review";
    $applied_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO applications
            (job_id, user_id, resume, status, applied_at)
            VALUES
            ('$job_id', '$user_id', '$resume', '$status', '$applied_at')";

    if (mysqli_query($conn, $sql)) {

        $message = "Your job application has been submitted successfully.";
        $created_at = date("Y-m-d H:i:s");

        $notificationSql = "INSERT INTO notifications
                            (user_id, message, created_at)
                            VALUES
                            ('$user_id', '$message', '$created_at')";

        mysqli_query($conn, $notificationSql);

        header("Location: myapplications.php");
        exit();

    } else {

        echo "Application Failed: " . mysqli_error($conn);

    }

} else {

    echo "Job not found!";

}

?>