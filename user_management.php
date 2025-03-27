<?php
session_start();

// Database connection
$servername = "localhost"; // change this to your database server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "user_management"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add New User
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Store the password securely in production (hashed)
    $role = $_POST['role'];

    if ($username && $password && $role !== '') {
        $password_hash = password_hash($password, PASSWORD_BCRYPT); // Hash password for security

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password_hash, $role);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #333;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, select {
            padding: 8px;
            width: 100%;
            margin-top: 5px;
        }

        input[type="submit"] {
            margin-top: 15px;
            background-color: #007BFF;
            border: none;
            color: white;
            cursor: pointer;
            width: auto;
        }
    </style>
</head>
<body>

    <h1>User Management</h1>

    <h2>Add New User</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">-- Choose Role --</option>
            <option value="Staff">Staff</option>
            <option value="Customer">Customer</option>
        </select>

        <input type="submit" value="Add User">
    </form>

</body>
</html>
