<?php
include "config.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $sql = "UPDATE seat_booking SET status=? WHERE booking_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: seat_accept.php"); // redirect back
    exit;
} else {
    echo "Invalid request.";
}
?>
