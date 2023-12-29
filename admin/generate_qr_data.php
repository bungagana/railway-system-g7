<?php
function generateQRData($crewId) {
    include 'connection.php';

    // Fetch crew data from the database (excluding the password)
    $stmt = $conn->prepare("SELECT crewId, name, username, department, userRole FROM users WHERE crewId = ?");
    $stmt->bind_param("s", $crewId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $crewData = $result->fetch_assoc();

        // Remove the password field from the crew data
        unset($crewData['password']);

        // Encode crew data as JSON
        $jsonCrewData = json_encode($crewData);

        // Close database connection
        $stmt->close();
        $conn->close();

        // Return JSON-encoded crew data
        return $jsonCrewData;
    } else {
        // Handle the case when crew data is not found
        return null;
    }
}
?>
