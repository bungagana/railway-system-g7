<?php
include '../php/connection.php';
session_start(); 

//========== GET PROFILE INFORMATION ============
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
//========== POST DATA TO DATABASE W/ CONDITION ============
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editMode'])) {
        // Edit mode: Update existing department
        $departmentId = $_POST['departmentId'];
        $departmentName = $_POST['departmentName'];
        $departmentDesc = $_POST['departmentDesc'];

        // Update data in the 'departments' table
        $updateQuery = "UPDATE departments SET departmentName='$departmentName', departmentDesc='$departmentDesc' WHERE departmentId='$departmentId'";

        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to department.php upon success
            echo "<script>
                    alert('Department updated successfully.');
                    window.location.href = 'department.php';
                 </script>";
            exit();
        } else {
            echo "Error updating department: " . $conn->error;
        }
    } else {
        // Create mode: Insert new department
        $departmentName = $_POST['departmentName'];
        $departmentDesc = $_POST['departmentDesc'];

        // Insert data into the 'departments' table
        $insertQuery = "INSERT INTO departments (departmentName, departmentDesc) VALUES ('$departmentName', '$departmentDesc')";

        if ($conn->query($insertQuery) === TRUE) {
            // Redirect to department.php upon success
            echo "<script>
                    alert('Department created successfully.');
                    window.location.href = 'department.php';
                 </script>";
            exit();
        } else {
            echo "Error creating department: " . $conn->error;
        }
    }

    $conn->close();
    exit(); 
}

//===== Check if edit mode is requested =======
if (isset($_GET['id'])) {
    $editMode = true;
    $departmentId = $_GET['id'];

    // Fetch department data for editing
    $result = $conn->query("SELECT * FROM departments WHERE departmentId='$departmentId'");
    $row = $result->fetch_assoc();
    $departmentName = $row['departmentName'];
    $departmentDesc = $row['departmentDesc'];
} else {
    $editMode = false;
    $departmentName = '';
    $departmentDesc = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create/Update Department</title>
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
            <div class="header">Department</div>
            <div class="info">
                <form method="post">
                    <?php if ($editMode): ?>
                        <input type="hidden" name="editMode" value="1">
                        <input type="hidden" name="departmentId" value="<?php echo $departmentId; ?>">
                    <?php endif; ?>

                    <label for="departmentName">Department Name :</label>
                    <input type="text" name="departmentName" value="<?php echo $departmentName; ?>" required>

                    <label for="departmentDesc">Department Description :</label>
                    <input type="text" name="departmentDesc" value="<?php echo $departmentDesc; ?>" required>

                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
