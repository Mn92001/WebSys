<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pentester - Login Result</title>
    <?php include "../inc/head.inc.php"; ?>
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
    <?php include "../inc/nav.inc.php"; ?>

    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
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

            $role = $row['Role'];
            if ($role == 'Pentester') {
                $approvalStatus = checkApprovalOfPentester($conn, $row['UserID']);
                if ($approvalStatus != "Approved") {
                    // Handle not approved case
                    echo "<div class='result-container'>";
                    echo "<h1>Oops!</h1>";
                    echo "<h4>Your account has not been approved.</h4>";
                    echo "<p>Please wait for an administrator to approve your account or contact support.</p>";
                    echo '<a href="../pages/login.php" class="btn btn-warning">Return to Login</a>';
                    echo "</div>";
                } else {
                    // Password verified, login successful
                    echo "<div class='result-container'>";
                    echo "<h1>Login successful!</h1>";
                    echo "<p>Welcome back, " . $row['FullName'] . " </p>";

                    // Start session after successful login
                    session_start(); 
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $row['Role'];

                    // Option to return to home page
                    echo '<a href="../index.php" class="btn btn-success">Return to Home</a>';
                    echo "</div>";
                }
            }  else{
                // Password verified, login successful
                echo "<div class='result-container'>";
                echo "<h1>Login successful!</h1>";
                echo "<p>Welcome back, " . $row['FullName'] . " </p>";

                // Start session after successful login
                session_start(); 
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['Role'];

                // Option to return to home page
                echo '<a href="../index.php" class="btn btn-success">Return to Home</a>';
                echo "</div>";
            } 
            
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

    
    function checkApprovalOfPentester($conn, $userID) {
        // Initialize the approval status
        $approvalStatus = "Pending";
    
        // Get the pentesterID corresponding to the userID
        $sql_pentester = "SELECT PentesterID FROM Pentester WHERE UserID = ?";
        $stmt_pentester = $conn->prepare($sql_pentester);
        $stmt_pentester->bind_param("i", $userID);
        $stmt_pentester->execute();
        $result_pentester = $stmt_pentester->get_result();
        $stmt_pentester->close();
    
        if ($result_pentester->num_rows > 0) {
            // Get the first (and should be only) row
            $pentester_row = $result_pentester->fetch_assoc();
            $pentesterID = $pentester_row['PentesterID'];
    
            // Query to check approval status
            $sql_approval = "SELECT ApprovalStatus FROM ApprovalOfPentester WHERE PentesterID = ?";
            $stmt_approval = $conn->prepare($sql_approval);
            $stmt_approval->bind_param("i", $pentesterID);
            $stmt_approval->execute();
            $result_approval = $stmt_approval->get_result();
            $stmt_approval->close();
    
            if ($result_approval->num_rows > 0) {
                // Get the approval status
                $approval_row = $result_approval->fetch_assoc();
                $approvalStatus = $approval_row['ApprovalStatus'];
            }
        }
        return $approvalStatus;
    }
    
    ?>

    <?php include "../inc/footer.inc.php"; ?>
</body>

</html>
