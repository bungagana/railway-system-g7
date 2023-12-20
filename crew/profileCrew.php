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

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/create.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  
    </style>
</head>

<body>

    <div class="wrapper">
    <div class="sidebar">
        <?php include 'sidebarCrew.php'; ?> 
        </div>
        <div class="main_content">
            <div class="header">Profile</div>

            <div class="info">
                <form method="post" action="profile.php">
                    <label for="crewId">Crew Id:</label>
                    <input type="text" id="crewId" name="crewId" value="<?php echo $user['crewId']; ?>" required readonly>

                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

                    <label for="department">Department</label>
                    <select name="department" required>
                        <option value="" disabled>Select Department</option>
                        <?php
                        foreach ($departmentOptions as $department) {
                            $selected = ($editUser['department'] == $department) ? 'selected' : '';
                            echo "<option value='{$department}' {$selected}>{$department}</option>";
                        }
                        ?>
                    </select>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">

                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">

                    <button type="submit">Save Changes</button>
                </form>


                <hr> 


            </div>
        </div>
    </div>

</body>

</html>
