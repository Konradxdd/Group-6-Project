<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        ['username' => 'Konrad', 'role' => 'Staff'],
        ['username' => 'Pushpey', 'role' => 'Customer']
    ];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Not stored — just for validation
    $role = $_POST['role'];

    if ($username && $password && $role !== '') {
        $_SESSION['users'][] = ['username' => htmlspecialchars($username), 'role' => $role];
    }
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $index = (int) $_GET['delete'];
    if (isset($_SESSION['users'][$index])) {
        unset($_SESSION['users'][$index]);
        $_SESSION['users'] = array_values($_SESSION['users']); // Reindex
    }
}
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
        <?php foreach ($_SESSION['users'] as $index => $user): ?>
            <li>
                <?php echo htmlspecialchars($user['username']) . " ({$user['role']})"; ?>
                <a href="?delete=<?php echo $index; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Remove</a>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>

