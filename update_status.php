<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $status = $_POST["status"];

    if (
        $status != "Under Review" &&
        $status != "Shortlisted" &&
        $status != "Rejected"
    ) {
        echo "Invalid status!";
        exit();
    }

    $sql = "UPDATE applications
            SET status='$status'
            ORDER BY applied_at DESC
            LIMIT 1";

    if (mysqli_query($conn, $sql)) {
        echo "Status updated successfully!";
    } else {
        echo "Status update failed: " . mysqli_error($conn);
    }
}

?>