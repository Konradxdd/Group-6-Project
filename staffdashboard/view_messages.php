<?php
session_start();
include '../database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages</title>
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
            <li><a href="staffprofile.html">Profile</a></li>
            <li><a href="../logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Manage Messages</h1>
        </header>

        <!-- Messages Section -->
        <section class="customer-reviews">
            <h2>User Messages</h2>
            <div class="reviews-container">

                <?php
                $sql = "SELECT * FROM messages ORDER BY message_id DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        echo '<div class="review">';
                        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                        echo "<p><strong>Message:</strong> " . htmlspecialchars($row['message']) . "</p>";

                        echo '<form action="delete_messages.php" method="POST" style="margin-top:10px;">';
                        echo '<input type="hidden" name="message_id" value="' . $row['message_id'] . '">';
                        echo '<button type="submit" class="delete-btn">Delete</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No messages found.</p>";
                }

                $conn->close();
                ?>

            </div>
        </section>

    </div>

</body>
</html>
