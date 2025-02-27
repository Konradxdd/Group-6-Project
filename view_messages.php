<?php
session_start();
include 'database.php';

$sql = "SELECT * FROM messages ORDER BY id DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "ID: " . $row['id'] . "<br>";
    echo "Name: " .htmlspecialchars($row['name']) . "<br>";
    echo "Email: " .htmlspecialchars($row['email']) . "<br>";
    echo "Phone: " .htmlspecialchars($row['phone']) . "<br>";
    echo "Message: " .htmlspecialchars($row['message']) . "<br>";

    echo '<form action="delete_messages.php" method="POST">';
    echo '<input type="hidden" name="id" value="' .$row['id'] . '">';
    echo '<button type="submit">Delete</button>';
    echo '</form>';
    echo "<hr>";
    
}
$conn->close();
?>
