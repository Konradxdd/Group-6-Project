<?php
session_start();
include '../database.php';


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
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="staff.css">
</head>
<body>

    <div class="sidebar">
        <h2>Staff Dashboard</h2>
        <ul>
            <li><a href="staff.html">Dashboard</a></li>
            <li><a href="manageflights.html">Manage Flights</a></li>
            <li><a href="staffm.html">Staff Management</a></li>
            <li><a href="refunds.php">Manage Refunds</a></li>
            <li><a href="view_messages.php">Manage Messages</a></li>
            <li><a href="user_management.php">Manage Users</a></li>
            <li><a href="staffprofile.html">Profile</a></li>
            <li><a href="../logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Manage Users</h1>
        </header>

        <div class="user-container">

            <div class="user-card">
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

                    <input type="submit" value="Add User" class="user-btn">
                </form>
            </div>

            <div class="user-card">
                <h2>Existing Users</h2>
                <ul class="user-list">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($user = $result->fetch_assoc()) {
                            echo "<li class='user-item'>" . htmlspecialchars($user['username']) . " ({$user['role']}) 
                            <a href='?delete={$user['id']}' class='btn user-btn' onclick='return confirm(\"Are you sure?\")'>Remove</a></li>";
                        }
                    } else {
                        echo "<li class='user-item'>No users found.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
