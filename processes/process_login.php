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

    include '../inc/db.php';

    // Retrieve input from login form
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Query to retrieve user information based on email
    $sql = "SELECT * FROM UserMaster WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];
        if (password_verify($password, $hashed_password)) {
            // Password verified, login successful
            echo "<div class='result-container'>";
            echo "<h1>Login successful!</h1>";
            echo "<p>Welcome back, " . $row['Fullname'] . " </p>";
            // Option to return to home page
            echo '<a href="index.php" class="btn btn-success">Return to Home</a>';
            echo "</div>";
        } else {
            // Password incorrect
            echo "<div class='result-container'>";
            echo "<h1>Oops!</h1>";
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>Password doesn't match...</p>";
            // Option to return to login page
            echo '<a href="../pages/login.php"" class="btn btn-warning">Return to Login</a>';
            echo "</div>";
        }
    } else {
        // User not found
        echo "<div class='result-container'>";
        echo "<h1>Oops!</h1>";
        echo "<h4>The following errors were detected:</h4>";
        echo "<p>Email not found</p>";
        // Option to return to login page
        echo '<a href="../pages/login.php"" class="btn btn-warning">Return to Login</a>';
        echo "</div>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
    ?>

    <?php include "inc/footer.inc.php"; ?>
</body>

</html>
