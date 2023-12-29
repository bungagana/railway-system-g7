<!-- navAdmin.php -->
<?php
session_start();

include '../php/connection.php';

// Check if the user is logged in
if (!isset($_SESSION['crewId'])) {
    header("Location: index.php");
    exit();
}

// Fetch user details from the database
$crewId = $_SESSION['crewId'];
$stmt = $conn->prepare("SELECT * FROM users WHERE crewId = ?");
$stmt->bind_param("s", $crewId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userRole = $user['userRole'];
} else {
    header("Location: index.php");
    exit();
}
$stmt->close();

// Load department options from the database
$departmentOptions = [];
$result = $conn->query("SELECT departmentName FROM departments");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departmentOptions[] = $row["departmentName"];
    }
}
// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $department = $_POST["department"];

    // Use prepared statement to prevent SQL injection
    $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ?, username = ?, department = ? WHERE crewId = ?");
    $updateStmt->bind_param("sssss", $name, $email, $username, $department, $crewId);
    $updateStmt->execute();

    // Close the statement
    $updateStmt->close();

    // Check if change password form is submitted
    if (isset($_POST['changePassword'])) {
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];

        // Verify that new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Update password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordStmt = $conn->prepare("UPDATE users SET password = ? WHERE crewId = ?");
            $updatePasswordStmt->bind_param("ss", $newHashedPassword, $crewId);
            $updatePasswordStmt->execute();
            $updatePasswordStmt->close();
        } else {
            echo "Mismatched new passwords.";
        }
    }

    // Refresh the page to reflect updated details
    header("Location: profile.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Infographic Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
    /* Add some styles to format the cards */
    .card {
        border: 1px solid #4b4276; /* Dark purple border */
        padding: 20px;
        margin: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: background-color 0.3s ease; /* Add a smooth transition effect */
    }

    .card:hover {
        background-color: #4b4276; /* Dark purple background on hover */
        color: #fff; /* White text on hover */
    }

    /* Style for the header */
    .header {
        font-size: 24px;
        margin-bottom: 20px;
        color: #4b4276; /* Dark purple header text */
    }

    /* Define colors for each card */
  
    .card.departments {
        background-color: #4b4276; /* Dark purple background for departments */
        color: #fff; /* White text for departments */
    }

    .card.crew {
        background-color: #fff; /* White background for crews */
        color: #4b4276; /* Dark purple text for crews */
    }

    .card.schedules {
        background-color: #000; /* Black background for schedules */
        color: #fff; /* White text for schedules */
    }
</style>

    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="main_content">
            <div class="header">Welcome! Have a nice day.</div>
            <div class="info">

                <?php
                include '../php/connection.php';

                $crewCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
                $departmentCount = $conn->query("SELECT COUNT(*) as count FROM departments")->fetch_assoc()['count'];
                $scheduleCount = $conn->query("SELECT COUNT(*) as count FROM schedules")->fetch_assoc()['count'];

                echo "<div class='card departments'><p>Total Departments</p><h3>$departmentCount</h3></div>";
                echo "<div class='card crew'><p>Total Crews</p><h3>$crewCount</h3></div>";
                echo "<div class='card schedules'><p>Total Schedules</p><h3>$scheduleCount</h3></div>";

                $conn->close();
                ?>
            </div>
        </div>
    </div>

</body>

</html>
