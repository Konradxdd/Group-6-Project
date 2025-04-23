<?php
include 'database.php';

$departure = isset($_GET['departure']) ? $_GET['departure'] : '';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';

if ($departure && $destination) {
    $sql = "SELECT DISTINCT flight_date FROM flights WHERE departure = ? AND destination = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $departure, $destination);
    $stmt->execute();
    $result = $stmt->get_result();

    $availableDates = [];
    while ($row = $result->fetch_assoc()) {
        $availableDates[] = $row['flight_date'];
    }

    echo json_encode($availableDates);
} else {
    echo json_encode([]); 
}

$conn->close();
?>
