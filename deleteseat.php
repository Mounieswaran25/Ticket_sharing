<?php
include "Config.php";

if (isset($_GET['csid'])) {
    $csid = $_GET['csid'];
    $sql = "DELETE FROM car_seat WHERE csid = $csid";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Seat deleted successfully'); window.location.href='vseat.php';</script>";
    } else {
        echo "<script>alert('Error deleting seat'); window.location.href='vseat.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='vseat.php';</script>";
}
?>
