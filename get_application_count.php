<?php

include "db.php";

$sql = "SELECT COUNT(*) AS total FROM applications";

$result = mysqli_query($conn, $sql);

if ($result) {

    $row = mysqli_fetch_assoc($result);

    echo $row["total"];

} else {

    echo "0";

}

?>