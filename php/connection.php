<?php
$servername = "20102110.kelasmm1.cloud";
$username = "kelasmmc_railweb";
$password = "webBunga123.";
$dbname = "kelasmmc_webRail";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
