<?php
session_start();
include 'database.php';

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['message_id'])) {
    $id = intval($_POST['message_id']);
    $sql = "DELETE FROM messages WHERE message_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i',$id);

    if($stmt->execute()) {
        echo "Message with ID $id deleted successfully.<br>";
        echo '<a href="view_messages.php">Go back</a>';
    }else{
        echo "Error deleting message.<br>";
    }
    $stmt->close();
}

    $conn->close();
    ?>