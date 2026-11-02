<?php

include "db.php";

$sql = "DELETE FROM applications
        ORDER BY applied_at DESC
        LIMIT 1";

if (mysqli_query($conn, $sql)) {
    echo "Application deleted successfully!";
} else {
    echo "Delete failed: " . mysqli_error($conn);
}

?>