
    <?php
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
            // Password verified, login successful
            echo "<div class='result-container'>";
            echo "<h1>Login successful!</h1>";
            echo "<p>Welcome back, " . $row['FullName'] . " </p>";

            // Start session after successful login
            session_start(); 
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['Role'];
            $_SESSION['user_id'] = $$row['UserID'];
            $_SESSION['success'] = "Login successful.";


            // Option to return to home page
            header("Location: ../index.php");
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

