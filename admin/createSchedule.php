<?php
include '../php/connection.php';

//========== GET PROFILE INFORMATION ============
session_start(); 
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
//========== POST DATA TO THE DB ============
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["fullName"];
    $crewID = $_POST["crewID"];
    $jobRoles = $_POST["jobRoles"];
    $dutyTime = $_POST["dutyTime"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];

    // save schedule data to db
    $stmt = $conn->prepare("INSERT INTO schedules (fullName, crewID, jobRoles, dutyTime, startTime, endTime) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $crewID, $jobRoles, $dutyTime, $startTime, $endTime);

    if ($stmt->execute()) {
        echo "Jadwal berhasil disimpan.";
        header("Location: viewSchedule.php"); 
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

//========== GET DEPARTMEN FROM DB ============
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
    <title>Create Schedule</title>
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
            <div class="header">Create Schedule</div>
            <div class="info">
                <form id="scheduleForm" method="post" action="createSchedule.php">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" name="fullName" required>

                    <label for="crewID">Crew ID:</label>
                    <input type="text" id="crewID" name="crewID" required>

                    <label for="jobRoles">Department:</label>
                    <select id="jobRoles" name="jobRoles" required>
                        <?php
                        foreach ($departmentOptions as $option) {
                            echo "<option value='$option'>$option</option>";
                        }
                        ?>
                    </select>

                    <label for="dutyTime">Duty Time:</label>
                    <input type="text" id="dutyTime" name="dutyTime" required>

                    <label for="startTime">Start Time:</label>
                    <input type="time" id="startTime" name="startTime" required>

                    <label for="endTime">End Time:</label>
                    <input type="time" id="endTime" name="endTime" required>

                    <button type="submit">Save Schedule</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
