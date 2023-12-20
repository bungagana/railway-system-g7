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

//========== DELET LOGIC  ============
// Delete crew logic
if (isset($_GET['deleteCrew']) && isset($_GET['crewId'])) {
    $crewId = $_GET['crewId'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM users WHERE crewId = '$crewId'";
    $result = $conn->query($deleteQuery);

    if ($result) {
        header("Location: crewView.php"); 
        exit();
    } else {
        echo "Error deleting crew: " . $conn->error;
    }
    
}

// Fetch crew data for display
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Schedule</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-r5gAtH1dLlI9HRvQILfmEis97zyZI7XGAAFPwOJXUJwn3rs6c5ISq9b6YQAd2MdazcVTPrjJ3L2QF5oaA9KCC5YRqj24KabbdFmCS0eKRz/11zZtg0R+CefFw98bJHIW3y/XsmF5lu3g8lJ8Uq7tsn44NXlMyDdf8tvwggstTnYGgA7d+sy/i9h+8Kck2J4jNYFv3HyAizn5eh5TAId9jOwCe5StZFyNXdY3vj/9rvo4Lv9B8T6EPx8y+9HX6d+Ds/3IMp5ARp6lA0RC5E+ZuoAaiKEvWIp2RIOlp0dVes4ARnbTjQKtqKce61tPCtwkY6ipHE2+dxyv1COAPnErJMp0IdZF+Ga2OL06S6MlA2O9GJFo89NXft/laTs7BgnA1zDUTMbR8b5byBokZgEVj+gibGYEe8AVcKWJDInQj8KcGDNn0A4DTt1DckdfYxbl0ZfkqzJQm11yzqy9Y9CTnxJW7W2DEMLh3ftJqCmgxgNQ5GiWZODPfKfI5gFjps5fTI2VqCJkFZ7AiZfnU2vTI7FUsUyjBHzq9Lz+9FdFqjclTUQy7Cb1VTYRdFO7FwjoOtdJnH2u/nlQ2fW/mFzpMqJdcY5R6j3Jt8nO92BPrFNerPvff9CpSVu5pBC8T7k7b+h5m4iZRL55G8XVR0P8QSHslOAYAzljlRpZjT7bQjQ2jDrfUpdXqIhiE9lYzw/+TsMLD1PfrMxP82PTYPswLPg+jBsZ/s8vMfJv8LHDtYreor+YBPd36ad+72XuNPnfdK4KAwEAANszOTczNzY0MTYwODkyMzA2NDM4MjY0Mjg5NzEzOTIwMzAzNjI2NTQ5MjA3MjYwNDI0OTQ0NjA0NzM3NDA5NzUwMzEwNTU0MjQxNTE1MDQ1MDY5NTM0MTI3NjA2MDIyMjkwNzI2MzUwNzEyMTUwNDE2MDEzNzAzMDA4MjAwNzQwMTM1MTEwNjA4NTczMzkwNzQxODk4NjEwMDk3NjA3NjE5NzYwNTQxNzE5MzYyMTYwNzU4ODQwOTM2MTE2MjEzNDk4ODA5Mjg1MTYyNzUxMDY4NzQwNjUxODk5MTQ2ODgxODU4ODQzNzQwMjU3MjI0MzUxMDY4NjI1MTU1MjQ3NjQ0ODc4NDM1NjYwMzUwNjgyODMwNjUzNDQxODY1NjI1NjM0NzI2NDgyMDY1MDk1MTU4NTU0MzQwOTkzMDMyNjc1NjYwMzM4NjMwNDY5NDE5ODY5MzE1NjI4NzQzNDI0NjM5MTAxNjIzNDk2NDYwNzYwMzUwOTM2MjIzODU1MjI1MTM1MTMxODc2MTIyNzA3MjEyMzUxMjIzODYyMDUzMjQ2OTEwNTQyNTM2MzQxODc1Njc1MTQ1NzM4NzMwNjYzOTAxMzk2MTU4MzUyOTUyMTAzMjExNDM1NTIwNTg3MDQ1NDY2MDcyNjc1MDg2OTU2NjMwMDY2MTAzNDMxNDc1ODc1NjU2OTJ8fG1vZGlmaWNhdGlvbi9yYW5nZTptZWRpYS9vcGVyYXRpb24tY2FyZCIsIi9hc3NldHMvdmlld1BsYXRmb3JtL2Jvb3RzdHJhcC9mb3JtYXQvYmxvZy9pbmRleC5waHAiLCIvYXBpL2Jvb3RzdHJhcC9ib290c3RyYXAubXNnaWYiLCIvYXBpL2Jvb3RzdHJhcC9wcm9maWxlLmNzcyIsIi9hcGkvYm9vdHN0cmFwL2Jvb3RzdHJhcCIsIi9hcGkvdmlldy9zY2hlbWEuanMiLCIvYXBpL2Jvb3RzdHJhcC9kZXBhcnRtZW50Lmh0bWwiLCIvYXBpL2Jvb3RzdHJhcC9wcm9maWxlLmJpbmQsIi9hcGkvdmlldy9zY2hlbWEucGhwIiwiaHR0cHM6Ly9kYi5naXRodWIuY29tL21kNS9hcGkvcGhvdG9zLzEuMy4wL2Rpc3QvY3NzL3N5cy1hcHBsaWNhdGlvbiJdLCJtb2JpbGUiOiJlbl9VUyJ9" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?> 
        </div>
        <div class="main_content">
            <div class="header">View Crew</div>

            <div class="info">
                <button onclick="location.href='../admin/crewCreate.php'">Create Crew</button>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <button onclick="searchCrew()">Search</button>
                </div>
                <table id="crewTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Crew ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Department</th>
                            <th>User Role</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="crewBody">
                        <?php
                        // Fetch user data from the database and display it in the table
                        include '../php/connection.php';
                        $result = $conn->query("SELECT * FROM users");

                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $counter++ . "</td>";
                                echo "<td>" . $row["crewId"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["department"] . "</td>";
                                echo "<td>" . $row["userRole"] . "</td>";
                                echo "<td><button class='edit-button' onclick=\"editCrew('{$row["crewId"]}')\">Edit</button></td>";
                              
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No users found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
                

            </div>
        </div>
    </div>

    <script>
     //========== EDIT FUNCTION ============
    function editCrew(crewId) {
        window.location.href = `../admin/crewEdit.php?crewID=${crewId}`;
    }
    //========== SEARCH FUN ============
    function searchCrew() {
            // Declare variables
            var input, filter, table, tbody, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("crewTable");
            tbody = document.getElementById("crewBody");
            tr = tbody.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                // Assume the crew name is in the second column (index 1)
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
</script>
</body>

</html>
