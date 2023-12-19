<?php
    include_once 'submit.php';
    header("Content-Type: text/html");
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <title>Admin Login</title>
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css”>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px grey;
            text-align: center;
        }

        #main {
        background-image: url('C:\Users\ASUS\Pictures\rail.jpg');
        background-repeat: no-repeat;
        background-size: cover;
    }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .form-group button {
            padding: 5px 20px;
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
            width: 400px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .captcha-img-btn {
        padding: 5px 20px;
        background-color: blue;
        color: white;
        border: 1px solid blue; /* adjust this value according to your requirement */
        cursor: pointer;
        width: 200px; /* adjust this value according to your requirement */
        }
    </style>
</head>
<body>
    <div class="container">
    <div id="main"></div>
        <h1>ADMIN LOGIN</h1>
        <form action="loginfirst.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <form action="" method="POST">
                <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>" data-action="LOGIN"></div>
                <div class="footer"><a href="forgotPass.php">Forgot Password?</a></div>
                <br/>
            <div class="form-group">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
    </div>
    <script> 
        function onSubmit(token) {
            document.getElementById("demo-form").submit();
        }
    </script>
</body>
</html>
