<?php
include '../php/connection.php';
// Start the session
session_start();

// Check if the connection is open before using it
if (!$conn->connect_error) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loginCrewId = $_POST["loginCrewId"];
        $loginPassword = $_POST["loginPassword"];
        $selectedUserRole = $_POST["userRole"];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT crewId, password, userRole FROM users WHERE crewId = ? AND userRole = ?");
        $stmt->bind_param("ss", $loginCrewId, $selectedUserRole);
        $stmt->execute();
        $stmt->bind_result($dbCrewId, $dbPassword, $userRole);

        // Initialize a variable to track whether credentials are valid
        $credentialsValid = false;

        // After successful password verification
        if ($stmt->fetch()) {
            if (password_verify($loginPassword, $dbPassword)) {
                // Set session variables
                $_SESSION['user_id'] = $dbCrewId;
                $_SESSION['crewId'] = $dbCrewId;

                // Redirect based on user role
                if ($userRole === "Admin") {
                    header("Location: ../admin/navAdmin.php");
                    exit;
                } elseif ($userRole === "Staff") {
                    header("Location: ../crew/dashCrew.php");
                    exit;
                } else {
                    // Handle other roles or redirect to a default page
                    header("Location: someDefaultPage.php");
                    exit;
                }
            } else {
                $errorMessage = "Invalid password.";
            }
        } else {
            $errorMessage = "Invalid crew ID or user role.";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} else {
    $errorMessage = "Connection error: " . $conn->connect_error;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/regis.css">
</head>

<body>
    <div class="container">
        <h2>L O G I N</h2>
        <form method="post" action="index.php" id="loginForm">
            <label for="loginCrewId">Crew ID:</label>
            <input type="text" id="loginCrewId" name="loginCrewId" placeholder="Crew ID" required value="<?php echo isset($_GET['loginCrewId']) ? $_GET['loginCrewId'] : ''; ?>">

            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="loginPassword" placeholder="Password" required>

            <label for="userRole">User Role:</label>
            <select name="userRole" required>
                <option value="" disabled selected>Select User Role</option>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
            </select>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="regis.php">Register</a></p>
        <?php if (isset($errorMessage)) : ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    <a href="home.php" class="back-button">Back to Home</a>
    </div>

    <script src="../js/login.js"></script>
</body>

</html>