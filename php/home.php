<!DOCTYPE html>
<html>
<head>
    <title>Railway Crews Schedule System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../images/ktm.jpg'); /* Replace 'path/to/your/image.jpg' with your local image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Optional - keeps the background fixed while scrolling */
        }

        header {
            background-color: #cdcdb1;
            color: black;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        header nav ul li {
            margin-left: 20px;
        }

        header nav ul li:first-child {
            margin-left: 0;
        }

        header nav ul li a {
            color: black;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        .welcome-section {
            background-color: #fff;
            padding: 10px; /* Reduced padding */
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Reduced shadow */
            width: 200px; /* Adjust the width */
            height: 200px; /* Adjust the height */
        }

        .welcome-section h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .welcome-section p {
            font-size: 1.1em;
            line-height: 1.6;
        }

        footer {
            text-align: center;
            padding: 0px;
            background-color: #333;
            color: #fff;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
<img src="../images/logo.png" alt="logo" width="150" height="auto">
    <h1>Welcome to Railway Crews Schedule System</h1>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="regis.php">Register</a></li>
            <li><a href="index.php">Login</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="welcome-section">
        <!-- Your existing content... -->
        
        <!-- Add the QR code image here -->
        <img src="../images/qrscan.png"  alt="QR Code" width="200" height="200">
        <!-- Replace 'path/to/your/qr_code_image.png' with the correct path to your QR code image -->
    </section>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Railway Crews Schedule System. All Rights Reserved.</p>
</footer>

</body>
</html>

