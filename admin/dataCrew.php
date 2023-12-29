<?php
// view_crew_data.php

// Retrieve crew data from the URL parameter
$jsonCrewData = urldecode($_GET['data']);
$crewData = json_decode($jsonCrewData, true);

// Display crew data as needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Crew Data</title>
    <!-- Add your styles and scripts as needed -->
</head>
<body>
    <h1>Crew Data</h1>
    <pre><?php print_r($crewData); ?></pre>
    <!-- You can format and display the crew data as needed -->
</body>
</html>
