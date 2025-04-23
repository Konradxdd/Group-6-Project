<?php
include 'database.php';

if (isset($_GET['departure'])) {
    $departure = $_GET['departure'];

    $sql = "SELECT DISTINCT destination FROM flights WHERE departure = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $departure);
    $stmt->execute();
    $result = $stmt->get_result();

    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row['destination'];
    }

    echo json_encode($destinations);
} else {
    echo json_encode([]);
}
?>
