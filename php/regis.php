<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crewId = $_POST["crewId"];
    $name = $_POST["fullName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $department = $_POST["department"];
    $userRole = $_POST["userRole"];

    $recaptchaSecretKey = "6LddKTUpAAAAAMogvjyKZIuNTjixmEf475cKZZce";
    $recaptchaResponse = $_POST["g-recaptcha-response"];

    // Verify reCAPTCHA
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse
    ];
    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($recaptchaData),
            'header' => 'Content-Type: application/x-www-form-urlencoded'
        ]
    ];
    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = json_decode(file_get_contents($recaptchaUrl, false, $recaptchaContext));

    if (!$recaptchaResult->success) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    if ($password !== $confirmpassword) {
        echo "Password and Confirm Password do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        include '../php/connection.php';

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Check if crewId already exists
$stmt = $conn->prepare("SELECT crewId FROM users WHERE crewId = ?");
$stmt->bind_param("s", $crewId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Crew ID already exists. Please choose a different one.";
    exit;
}
// Check if email already exists
$stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email already exists. Please use a different email.";
    exit;
}

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (crewId, name, email, username, password, department, userRole) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $crewId, $name, $email, $username, $hashedPassword, $department, $userRole);

        if ($stmt->execute()) {
            echo "Congrats! Your account has been created.";
            header("Location: index.php?loginCrewId=$crewId&userRole=$userRole");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }


        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registrasi</title>
    <link rel="stylesheet" type="text/css" href="../css/regis.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="container">
        <h2>R E G I S T E R</h2>

        <form method="post" action="regis.php" id="registrationForm">
            <label for="crewId">Crew ID:</label>
            <input type="text" id="crewId" name="crewId" placeholder="Enter Crew ID" required>

            <label for="name">Full Name:</label>
            <input type="text" id="name" name="fullName" placeholder="Enter Full Name" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter Email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password Min 8 character" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#?]).{8,}$" title="Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character." required>

            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>

            <label for="department">Department:</label>
            <select name="department" required>
                <option value="" disabled selected>Select Department</option>
                <?php
                    // Database connection
                    include '../php/connection.php';

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to get departments
                    $departmentQuery = "SELECT departmentName FROM departments";
                    $departmentResult = $conn->query($departmentQuery);

                    // Check if there are departments
                    if ($departmentResult->num_rows > 0) {
                        // Output data of each row
                        while ($row = $departmentResult->fetch_assoc()) {
                            $departmentName = $row["departmentName"];
                            echo "<option value='$departmentName'>$departmentName</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No departments available</option>";
                    }

                    // Close the database connection
                    $conn->close();
                ?>
            </select>

            <label for="userRole">User Role:</label>
            <select name="userRole" required>
                <option value="" disabled selected>Select User Role</option>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
            </select>

            <div class="g-recaptcha" data-sitekey="6LddKTUpAAAAAN_NKCpMMpnHVoiP0qHvGbkj3Nys"></div>
            <button type="submit">Register</button>
        </form>

        <p>Already Have Account? <a href="index.php">Login</a></p>
        <p id="registrationMessage"></p>
        <a href="home.php" class="back-button">Back to Home</a>
    </div>

    <script src="../js/regis.js"></script>
</body>

</html>
