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

//========== GET DEPART ============
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
    $updateStmt->close();

    // Check if change password form is submitted
    if (isset($_POST['changePassword'])) {
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];

        // Verify old password
        $hashedPassword = $user['password'];
        if (password_verify($oldPassword, $hashedPassword)) {
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
        } else {
            echo "Incorrect old password.";
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
             <div class="profile_info profile_info_center">
        <img src="../images/profile.jpg" alt="Profile Picture">
        <h2><?php echo $crewId; ?></h2>
        <h4>admin</h4>
     </div>
        <ul>
            <li><a href="../admin/navAdmin.php"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="../admin/viewSchedule.php"><i class="fas fa-list"></i>Schedule</a></li>
            <li><a href="../admin/crewView.php"><i class="fas fa-list"></i>Crew</a></li>
            <li><a href="../admin/department.php"><i class="fas fa-project-diagram"></i>Department</a></li>
            <li><a href="../admin/profile.php"><i class="fas fa-address-card"></i>Profile</a></li>
            <li><a href="../php/index.php" onclick="return confirm('Are you sure you want to log out?')"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>
        </ul>

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
                    <label for="oldPassword">Old Password:</label>
                    <input type="password" id="oldPassword" name="oldPassword" placeholder="Old Password" required>

                    <label for="newPassword">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>

                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>

                    <button type="submit" name="changePassword">Change Password</button>
                </form>


                <hr> 


            </div>
        </div>
    </div>

</body>

</html>
