<?php
include '../php/connection.php';

//========== GET PROFILE INFORMATION ============
session_start(); 
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
// Retrieve crewId from the URL
$editCrewId = $_GET["crewID"];


//========== GET DETAIL CREW INFORMATION ============
// Fetch user data for the crewId
$stmt = $conn->prepare("SELECT * FROM users WHERE crewId=?");
$stmt->bind_param("s", $editCrewId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $editUser = $result->fetch_assoc();
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

//========== POST DATA  ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmedPassword = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $userRole = mysqli_real_escape_string($conn, $_POST['userRole']);

    // Validate the password if it's not empty
    if (!empty($password) && $password !== $confirmedPassword) {
        echo "Error: Passwords do not match.";
        exit();
    }

    // Update the user data in the database
    $updateQuery = "UPDATE users SET name='$fullName', email='$email', username='$username', department='$department', userRole='$userRole'";
    
    // Update the password if it's not empty
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery .= ", password='$hashedPassword'";
    }

    $updateQuery .= " WHERE crewId='$editCrewId'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>
                alert('User information updated successfully');
                // Redirect to crewView.php
                window.location.href = 'crewView.php';
              </script>";
        exit();
    } else {
        // Handle the error
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/create.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>>
        <div class="main_content">
            <div class="header">Edit User</div>
            <div class="info">
                <form id="userForm" method="post" action="">
                    <label for="crewId">Crew ID</label>
                    <input type="text" id="crewId" name="crewId" placeholder="Crew ID" value="<?php echo $editUser['crewId']; ?>" disabled>

                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name" value="<?php echo $editUser['name']; ?>" required>

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $editUser['email']; ?>" required>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $editUser['username']; ?>" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">

                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">

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

                    <label for="userRole">User Role</label>
                    <select name="userRole" required>
                        <option value="" disabled>Select User Role</option>
                        <option value="Admin" <?php echo ($editUser['userRole'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="Staff" <?php echo ($editUser['userRole'] == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                    </select>

                    <div>
                        <button type="submit">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
