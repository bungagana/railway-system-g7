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

//========== DELET LOGIC  ============
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $departmentId = $_GET['id'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM departments WHERE departmentId = '$departmentId'";
    $result = $conn->query($deleteQuery);

    if ($result) {
        header("Location: department.php"); 
        exit();
    } else {
        echo "Error deleting department: " . $conn->error;
    }
}

// Fetch department data for display
$result = $conn->query("SELECT * FROM departments");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Department</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-r5gAtH1dLlI9HRvQILfmEis97zyZI7XGAAFPwOJXUJwn3rs6c5ISq9b6YQAd2MdazcVTPrjJ3L2QF5oaA9KCC5YRqj24KabbdFmCS0eKRz/11zZtg0R+CefFw98bJHIW3y/XsmF5lu3g8lJ8Uq7tsn44NXlMyDdf8tvwggstTnYGgA7d+sy/i9h+8Kck2J4jNYFv3HyAizn5eh5TAId9jOwCe5StZFyNXdY3vj/9rvo4Lv9B8T6EPx8y+9HX6d+Ds/3IMp5ARp6lA0RC5E+ZuoAaiKEvWIp2RIOlp0dVes4ARnbTjQKtqKce61tPCtwkY6ipHE2+dxyv1COAPnErJMp0IdZF+Ga2OL06S6MlA2O9GJFo89NXft/laTs7BgnA1zDUTMbR8b5byBokZgEVj+gibGYEe8AVcKWJDInQj8KcGDNn0A4DTt1DckdfYxbl0ZfkqzJQm11yzqy9Y9CTnxJW7W2DEMLh3ftJqCmgxgNQ5GiWZODPfKfI5gFjps5fTI2VqCJkFZ7AiZfnU2vTI7FUsUyjBHzq9Lz+9FdFqjclTUQy7Cb1VTYRdFO7FwjoOtdJnH2u/nlQ2fW/mFzpMqJdcY5R6j3Jt8nO92BPrFNerPvff9CpSVu5pBC8T7k7b+h5m4iZRL55G8XVR0P8QSHslOAYAzljlRpZjT7bQjQ2jDrfUpdXqIhiE9lYzw/+TsMLD1PfrMxP82PTYPswLPg+jBsZ/s8vMfJv8LHDtYreor+YBPd36ad+72XuNPnfdK4KAwEAANszOTczNzY0MTYwODkyMzA2NDM4MjY0Mjg5NzEzOTIwMzAzNjI2NTQ5MjA3MjYwNDI0OTQ0NjA0NzM3NDA5NzUwMzEwNTU0MjQxNTE1MDQ1MDY9Y2FyZC9qcyIsIi9hc3NldHMvdmlld1BsYXRmb3JtL2Jvb3RzdHJhcC9mb3JtYXQvYmxvZy9pbmRleC5waHAiLCIvYXBpL2Jvb3RzdHJhcC9ib290c3RyYXAubXNnaWYiLCIvYXBpL2Jvb3RzdHJhcC9wcm9maWxlLmNzcyIsIi9hcGkvYm9vdHN0cmFwL2Jvb3RzdHJhcCIsIi9hcGkvdmlldy9zY2hlbWEuanMiLCIvYXBpL2Jvb3RzdHJhcC9kZXBhcnRtZW50Lmh0bWwiLCIvYXBpL2Jvb3RzdHJhcC9wcm9maWxlLmJpbmQsIi9hcGkvdmlldy9zY2hlbWEucGhwIiwiaHR0cHM6Ly9kYi5naXRodWIuY29tL21kNS9hcGkvcGhvdG9zLzEuMy4wL2Rpc3QvY3NzL3N5cy1hcHBsaWNhdGlvbiJdLCJtb2JpbGUiOiJlbl9VUyJ9" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>

<div class="wrapper">
<div class="sidebar">
        <?php include 'sidebar.php'; ?> 
        </div>
        <div class="main_content">
            <div class="header">View Department</div>

            <div class="info">
                <button onclick="location.href='../admin/createDepartment.php'">Create Department</button>
                <table id="departmentTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Department Name</th>
                            <th>Department Description</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="departmentBody">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $counter++ . "</td>";
                                echo "<td>" . $row["departmentName"] . "</td>";
                                echo "<td>" . $row["departmentDesc"] . "</td>";
                                echo "<td><button class='edit-button' onclick=\"editDepartment('{$row["departmentId"]}')\">Edit</button></td>";
                                echo "<td><button class='delete-button' onclick=\"deleteDepartment('{$row["departmentId"]}')\">Delete</button></td>";
                                echo "</tr>";
                            }}}
                        } else {
                            echo "<tr><td colspan='5'>No Department found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // ------- Edit Function ----------
        function editDepartment(departmentId) {
            window.location.href = `../admin/createDepartment.php?id=${departmentId}`;
        }

        // ------- Delete Function ----------
        function deleteDepartment(departmentId) {
            const confirmDelete = confirm(`Are you sure you want to delete this department with ID ${departmentId}?`);
            if (confirmDelete) {
                window.location.href = `department.php?delete=true&id=${departmentId}`;
            }
        }
    </script>
</body>

</html>
