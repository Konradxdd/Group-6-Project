<?php
session_start();
include 'database.php';

// Add New User
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Plain text password
    $role = strtolower(trim($_POST['role'])); // Make sure the role is lowercase

    if (!empty($username) && !empty($password) && !empty($role)) {
        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        if (!$check) {
            die("Prepare failed (Check Username): " . $conn->error);
        }
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            die("Error: Username already taken.");
        }
        $check->close();

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed (Insert User): " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $password, $role);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        echo "<script>alert('User added successfully.'); window.location.href='user_management.php';</script>";
        $stmt->close();
    } else {
        echo "<script>alert('All fields are required.');</script>";
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
