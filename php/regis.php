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
            <input type="text" id="crewId" name="crewId" placeholder="Crew ID" required>
            <input type="text" id="name" name="fullName" placeholder="Full Name" required>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
            <select name="department" required>
                <option value="" disabled selected>Select Department</option>
                <?php
                    $departments = ["Department1", "Department2", "Department3"];

                    foreach ($departments as $department) {
                        echo "<option value='$department'>$department</option>";
                    }
                ?>
            </select>
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
    </div>

    <script src="../js/regis.js"></script>
</body>

</html>