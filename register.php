<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, password)
            VALUES ('$name', '$email', '$phone', '$password')";

    if (mysqli_query($conn, $sql)) {

        header("Location: login.html");
        exit();

    } else {

        echo "Registration Failed: " . mysqli_error($conn);

    }
}
?>