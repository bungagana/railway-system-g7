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
    // Redirect to login if the user doesn't exist
    header("Location: index.php");
    exit();
}
//========== POST DATA  ============
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crewId = $_POST["crewId"];
    $name = $_POST["fullName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $department = $_POST["department"];
    $userRole = $_POST["userRole"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (crewId, name, email, username, password, department, userRole) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $crewId, $name, $email, $username, $hashedPassword, $department, $userRole);

    if ($stmt->execute()) {
        echo "User successfully created.";
        header("Location: ../admin/crewView.php");
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

//========== GET DEPART FROM DB ============
$departmentOptions = [];
$result = $conn->query("SELECT departmentName FROM departments");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departmentOptions[] = $row["departmentName"];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/create.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?> 
        </div>
        <div class="main_content">
            <div class="header">Create User</div>
            <div class="info">
                <form id="userForm" method="post" action="crewCreate.php">
                    <input type="text" id="crewId" name="crewId" placeholder="Crew ID" required>
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name" required>
                    <input type="text" id="email" name="email" placeholder="Email" required>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                    <select name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php
                        foreach ($departmentOptions as $option) {
                            echo "<option value='$option'>$option</option>";
                        }
                        ?>
                    </select>
                    <select name="userRole" required>
                        <option value="" disabled selected>Select User Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                    </select>

                    <button type="submit">Create User</button>
                </form>
            </div>
        </div>
    </div>
  
</body>

</html>
