<?php
$servername = "kelasmmc_webRail";
$username = "railweb";
$password = "webBunga123";
$dbname = "kelasmmc_webRail";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
