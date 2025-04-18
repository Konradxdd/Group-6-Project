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
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <nav>
            <div class="logo">Polish Air</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="flights.php">Flights</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html" class="active">Contact</a></li>
                <li><a href="authorize.php" class="active">Login / Register</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="user-container">
        <h1>User Management</h1>

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

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Airline Booking. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
