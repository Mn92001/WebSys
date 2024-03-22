<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pentester - Login Result</title>
    <?php include "inc/head.inc.php"; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .result-container {
            max-width: 600px;
            margin: auto;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 50px;
        }

        h1,
        h4 {
            margin-bottom: 10px;
        }

        h1 {
            font-size: 36px;
            color: #ff6347; /* Red color for error */
        }

        h4 {
            font-size: 24px;
            color: #ff6347; /* Red color for error */
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }

        .btn-warning {
            background-color: #ff6347; /* Red color for error */
            color: #fff;
        }

        .btn-success {
            background-color: #008000; /* Green color for success */
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include "inc/nav.inc.php"; ?>

    <?php
    // Database configuration
    $servername = "localhost"; // Change this to your MySQL server hostname
    $username = "inf1005-sqldev"; // Change this to your MySQL username
    $password = "racHelpoH09"; // Change this to your MySQL password
    $database = "world_of_pets"; // Change this to your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve input from login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to retrieve user information based on email
    $sql = "SELECT * FROM world_of_pets_members WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            // Password verified, login successful
            echo "<div class='result-container'>";
            echo "<h1>Login successful!</h1>";
            echo "<p>Welcome back, " . $row['fname'] . " " . $row['lname'] . ".</p>";
            // Option to return to home page
            echo '<a href="home.php" class="btn btn-success">Return to Home</a>';
            echo "</div>";
        } else {
            // Password incorrect
            echo "<div class='result-container'>";
            echo "<h1>Oops!</h1>";
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>Email not found or password doesn't match...</p>";
            // Option to return to login page
            echo '<a href="login.php" class="btn btn-warning">Return to Login</a>';
            echo "</div>";
        }
    } else {
        // User not found
        echo "<div class='result-container'>";
        echo "<h1>Oops!</h1>";
        echo "<h4>The following errors were detected:</h4>";
        echo "<p>Email not found or password doesn't match...</p>";
        // Option to return to login page
        echo '<a href="login.php" class="btn btn-warning">Return to Login</a>';
        echo "</div>";
    }

    // Close connection
    $conn->close();
    ?>

    <?php include "inc/footer.inc.php"; ?>
</body>

</html>
