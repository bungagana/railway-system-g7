<?php
$servername = "https://20102110.kelasmm1.cloud/";
$username = "root";
$password = "";
$dbname = "kelasmmc_webProject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
