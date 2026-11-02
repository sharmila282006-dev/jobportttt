<?php

session_start();

include "db.php";

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
        ORDER BY applications.applied_at DESC
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $application = mysqli_fetch_assoc($result);

    echo json_encode($application);

} else {

    echo json_encode([]);

}

?>