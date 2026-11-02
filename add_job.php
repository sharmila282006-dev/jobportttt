<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $company = $_POST["company"];
    $location = $_POST["location"];
    $salary = $_POST["salary"];
    $experience = $_POST["experience"];

    $sql = "INSERT INTO jobs
            (title, company, location, salary, experience)
            VALUES
            ('$title', '$company', '$location', '$salary', '$experience')";

    if (mysqli_query($conn, $sql)) {

        echo "Job added successfully!";

    } else {

        echo "Job add failed: " . mysqli_error($conn);

    }

}

?>