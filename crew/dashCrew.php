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
    // Redirect to login if the user doesn't exist
    header("Location: index.php");
    exit();
}
// Close the statement
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

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Side Navigation Bar</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>
<body>

    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebarCrew.php'; ?>
        </div>
        <div class="main_content">
            <div class="header">Welcome! Have a nice day.</div>
            <div class="info">
                <h2>Dashboard Content</h2>
                <?php
                include '../php/connection.php';

                $crewCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
                $departmentCount = $conn->query("SELECT COUNT(*) as count FROM departments")->fetch_assoc()['count'];
                $scheduleCount = $conn->query("SELECT COUNT(*) as count FROM schedules")->fetch_assoc()['count'];

                echo "<p>Total Crews: $crewCount</p>";
                echo "<p>Total Departments: $departmentCount</p>";
                echo "<p>Total Schedules: $scheduleCount</p>";

                $conn->close();
                ?>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Crews', 'Departments', 'Schedules'],
                    datasets: [{
                        label: 'Counts',
                        data: [<?php echo $crewCount; ?>, <?php echo $departmentCount; ?>, <?php echo $scheduleCount; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
