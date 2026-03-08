<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bid'])) {
    $bid = $_POST['bid'];
    mysqli_query($conn, "UPDATE booking SET status='Accepted' WHERE bid='$bid'");
    echo "<script>alert('Booking Accepted'); window.location.href='seller_bookings.php';</script>";
}
?>
