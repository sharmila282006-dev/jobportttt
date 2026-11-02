<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo "Please login first!";
    exit();
}

$user_id = $_SESSION["user_id"];

/* Check current alert status */
$checkQuery = "SELECT id, enabled FROM job_alerts
               WHERE user_id='$user_id'";

$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {

    $alert = mysqli_fetch_assoc($checkResult);

    if ($alert["enabled"] == 1) {

        $sql = "UPDATE job_alerts
                SET enabled=0
                WHERE user_id='$user_id'";

        mysqli_query($conn, $sql);

        echo "Job Alerts disabled!";

    } else {

        $sql = "UPDATE job_alerts
                SET enabled=1
                WHERE user_id='$user_id'";

        mysqli_query($conn, $sql);

        echo "Job Alerts enabled! 🔔";
    }

} else {

    $sql = "INSERT INTO job_alerts (user_id, enabled)
            VALUES ('$user_id', 1)";

    if (mysqli_query($conn, $sql)) {
        echo "Job Alerts enabled! 🔔";
    } else {
        echo "Unable to enable Job Alerts.";
    }
}

?>