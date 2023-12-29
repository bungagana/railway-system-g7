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
//========== POST DATA  ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $jobRoles = mysqli_real_escape_string($conn, $_POST['jobRoles']);
    $dutyTime = mysqli_real_escape_string($conn, $_POST['dutyTime']);
    $startTime = mysqli_real_escape_string($conn, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($conn, $_POST['endTime']);
    
    // Check if $_GET['crewID'] is set
    $crewID = isset($_GET['crewID']) ? mysqli_real_escape_string($conn, $_GET['crewID']) : '';

    // Update the schedule data in the database
    $updateQuery = "UPDATE schedules SET fullName='$fullName', jobRoles='$jobRoles', dutyTime='$dutyTime', startTime='$startTime', endTime='$endTime' WHERE crewID='$crewID'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>
                alert('Record updated successfully');
                window.location.href = 'viewSchedule.php';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Retrieve crewID from the query parameter
$crewID = isset($_GET['crewID']) ? $_GET['crewID'] : '';

// Check if the crewID is empty
if (empty($crewID)) {
    // If the crewID is not found or empty, redirect to viewSchedule.php or handle it as appropriate
    header('Location: viewSchedule.php');
    exit();
}

// Fetch data for the specific crewID from the database
$result = $conn->query("SELECT * FROM schedules WHERE crewID = '$crewID'");

// Check if the query was successful
if ($result->num_rows > 0) {
    // Fetch the schedule data
    $schedule = $result->fetch_assoc();
} else {
    // If the crewID is not found, redirect to viewSchedule.php or handle it as appropriate
    header('Location: viewSchedule.php');
    exit();
}

// Fetch department options from the database
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
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/edit.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?> 
        </div>
        <div class="main_content">
            <div class="header">Edit Schedule</div>

            <div class="info">
                <form id="editScheduleForm" method="post" onsubmit="return confirm('Are you sure you want to save changes?');">
                    <label for="fullName">Full Name:</label>
                    <input type="text" name="fullName" id="fullName" value="<?php echo $schedule['fullName']; ?>" required>

                    <label for="crewID">Crew ID:</label>
                    <input type="text" name="crewID" id="crewID" value="<?php echo $schedule['crewID']; ?>" required disabled>
                    <label for="jobRoles">Department:</label>
                    <select id="editJobRoles" name="jobRoles" required>
                        <?php
                        foreach ($departmentOptions as $option) {
                            $selected = ($schedule['jobRoles'] == $option) ? 'selected' : '';
                            echo "<option value='$option' $selected>$option</option>";
                        }
                        ?>
                    </select>

                    <label for="dutyTime">Duty Time (*Hour):</label>
                    <input type="text" name="dutyTime" id="dutyTime" value="<?php echo $schedule['dutyTime']; ?>" required>

                    <label for="startTime">Start Time:</label>
                    <input type="time" name="startTime" id="startTime" value="<?php echo $schedule['startTime']; ?>" required>

                    <label for="endTime">End Time:</label>
                    <input type="time" name="endTime" id="endTime" value="<?php echo $schedule['endTime']; ?>" required>

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script>

    </script>

</body>

</html>
