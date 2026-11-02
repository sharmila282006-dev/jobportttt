<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $job_id = $_POST["job_id"];

    $sql = "DELETE FROM jobs WHERE id='$job_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Job deleted successfully!";
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
}

?>