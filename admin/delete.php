<?php
include '../php/connection.php';

if (isset($_GET['crewID'])) {
    $crewID = $_GET['crewID'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM schedules WHERE crewID = '$crewID'";
    
    $result = $conn->query($deleteQuery);

    if ($result) {
        header("Location: viewSchedule.php"); 
        exit();
    } else {
        echo "Error deleting schedule: " . $conn->error;
    }
} else {
    echo "Invalid request. Crew ID not provided.";
}

$conn->close();
?>
