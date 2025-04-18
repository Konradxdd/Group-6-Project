<?php
session_start();
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';
            $flight_id = isset($_POST['flight_id']) ? $_POST['flight_id'] : '';

            if ($redirect == 'booking.php' && !empty($flight_id)) {
                header("Location: booking.php?flight_id=" . $flight_id);
                exit();
            }

            if ($user['role'] == 'staff') {
                header("Location: staff.html");
            } else {
                header("Location: index.html");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
