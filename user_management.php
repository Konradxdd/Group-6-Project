<?php
session_start();
include 'database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 
    $role = strtolower(trim($_POST['role'])); 

    if (!empty($username) && !empty($password) && !empty($role)) {
       
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


if (isset($_GET['delete'])) {
    $userId = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed (Delete User): " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='user_management.php';</script>";
    } else {
        echo "<script>alert('Error: Could not delete user.');</script>";
    }
    $stmt->close();
}

$result = $conn->query("SELECT id, username, role FROM users");
if ($result === false) {
    die("Error fetching users: " . $conn->error);
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

        ul {
            list-style: none;
            padding: 0;
            background: white;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }

        li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .delete-btn {
            color: red;
            text-decoration: none;
            margin-left: 10px;
        }

        .delete-btn:hover {
            text-decoration: underline;
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

    <h2>Existing Users</h2>
    <ul>
        <?php
       
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($user['username']) . " ({$user['role']}) 
                <a href='?delete={$user['id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Remove</a></li>";
            }
        } else {
            echo "<li>No users found.</li>";
        }
        ?>
    </ul>

</body>
</html>
