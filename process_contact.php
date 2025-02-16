<?php
session_start();
include 'database.php';

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];

$sql = "INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssis", $name, $email, $phone, $message);

if ($stmt->execute()) {
    header("Location: index.html");
} else {
    echo "Error. Please try again." . $stmt->error;
}
?>