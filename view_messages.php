<?php
session_start();
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
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
                <li><a href="contact.html">Contact</a></li>
                <li><a href="authorize.php">Login / Register</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
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

    <!-- Footer -->
    <footer class="messages-footer">
        <div class="footer-content">
            <p>&copy; 2025 Polish Air. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
