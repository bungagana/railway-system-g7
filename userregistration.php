<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        /* Style for form */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            box-sizing: border-box;
            border: 5px solid #ccc;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            width: 80%; /* Adjust the width as needed */
            margin: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>User Registration</h2>
        <form action="nav.html" method="post" onsubmit="return validateForm()">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required><br><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phonenumber">Phone Number (Malaysian Format):</label>
            <input type="tel" id="phonenumber" name="phonenumber" pattern="^0\d{9,10}$" title="Please enter a valid Malaysian phone number" required><br><br>

            <label for="userid">User ID (Numeric Only):</label>
            <input type="text" id="userid" name="userid" pattern="\d+" title="Please enter numeric characters only" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#?]).{8,}$" title="Please meet the password requirements.At least 8 characters
            A mixture of both uppercase and lowercase letters
            A mixture of letters and numbers
            Inclusion of at least one special character, e.g., ! @ # ? ]" required><br><br>

            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" required><br><br>
            
            <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LddKTUpAAAAAN_NKCpMMpnHVoiP0qHvGbkj3Nys"></div>

            <input type="submit" value="Sign Up">
        </form>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmpassword").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please enter the same password in both fields.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
