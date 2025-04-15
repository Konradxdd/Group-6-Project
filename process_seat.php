<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'], $_SESSION['flight_id'], $_POST['seat'])) {
    echo "error";
    exit();
}

$user_id = $_SESSION['user_id'];
$flight_id = $_SESSION['flight_id'];
$seat = $_POST['seat'];
$booking_date = date("Y-m-d H:i:s");
$booking_status = "Confirmed"; 

$stmt = $conn->prepare("SELECT booking_id FROM bookings WHERE flight_id = ? AND seat_number = ?");
$stmt->bind_param("is", $flight_id, $seat);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "taken";
    exit();
}

$stmt = $conn->prepare("INSERT INTO bookings (user_id, flight_id, seat_number, booking_date, booking_status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $user_id, $flight_id, $seat, $booking_date, $booking_status);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
?>
