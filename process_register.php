
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
    <title>World of Pets - Registration Result</title> 
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
        color: #008000; 
        /* Green color for success */ 
    } 
 
    h4 { 
        font-size: 24px; 
        color: #ff6347; 
        /* Red color for error */ 
    } 
 
    p { 
        font-size: 18px; 
        color: #555; 
    } 
 
    .btn-success { 
        background-color: #008000; 
        /* Green color for success */ 
        color: #fff; 
    } 
 
    .btn-error { 
        background-color: #ff6347; 
        /* Red color for error */ 
        color: #fff; 
    } 
 
    .btn { 
        padding: 10px 20px; 
        text-decoration: none; 
        border-radius: 5px; 
        font-size: 16px; 
        margin-top: 20px; 
        display: inline-block; 
    } 
    </style> 
</head> 
 
<body> 
    <?php include "inc/nav.inc.php"; ?> 
 
    <?php 
    // Initialize variables to store form data and error messages 
    $fname = $lname = $email = $pwd = $pwd_confirm = $agree = ""; 
    $errorMsg = ""; 
    $success = true; 
 
    // Helper function to sanitize input 
    function sanitize_input($data) 
    { 
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data); 
        return $data; 
    } 
 
    // Validate and sanitize first name 
    if (empty($_POST["fname"])) { 
        $errorMsg .= "First Name is required.<br>"; 
        $success = false; 
    } else { 
        $fname = sanitize_input($_POST["fname"]); 
        // Additional checks for the first name if needed 
    } 
 
    // Validate and sanitize last name 
    if (empty($_POST["lname"])) { 
        $errorMsg .= "Last Name is required.<br>"; 
        $success = false; 
    } else { 
        $lname = sanitize_input($_POST["lname"]); 
        // Additional checks for the last name if needed 
    } 
 
    // Validate and sanitize email 
    if (empty($_POST["email"])) { 
        $errorMsg .= "Email is required.<br>"; 
        $success = false; 
    } else { 
        $email = sanitize_input($_POST["email"]); 
        // Additional check to make sure the email address is well-formed. 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $errorMsg .= "Invalid email format.<br>"; 
            $success = false; 
        } 
    } 
 
    // Validate and sanitize password 
    if (empty($_POST["pwd"])) { 
        $errorMsg .= "Password is required.<br>"; 
        $success = false; 
    } else { 
        $pwd = sanitize_input($_POST["pwd"]); 
        // Additional checks for the password if needed 
    } 
 
    // Validate and sanitize password confirmation 
    if (empty($_POST["pwd_confirm"])) { 
        $errorMsg .= "Confirm Password is required.<br>"; 
        $success = false; 
    } else { 
        $pwd_confirm = sanitize_input($_POST["pwd_confirm"]); 
        // Additional checks for password confirmation if needed 
    } 
 
    // Validate agreement checkbox 
    if (empty($_POST["agree"])) { 
        $errorMsg .= "Agree to terms and conditions is required.<br>"; 
        $success = false; 
    } 
 
    // Check if passwords match 
    if ($pwd !== $pwd_confirm) { 
        $errorMsg .= "Passwords do not match.<br>"; 
        $success = false; 
    } 
 
    // Add additional validations and sanitizations as needed 
 
    if ($success) {  
        // Hash the password  
        $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);  
      
        // Save the member to the database  
        saveMemberToDB($fname, $lname, $email, $pwd_hashed);  
      
        // Check if the data was saved successfully

if ($success) {  
            // Display success message  
            echo "<div class='result-container'>";  
            echo "<h1>Registration Successful!</h1>";  
            echo "<p>Thank you for signing up, $fname $lname.</p>";  
            echo "<a href='login.php' class='btn btn-success'>Log-in</a>";  
            echo "</div>";  
        } else {  
            // Display error message if database insertion failed  
            echo "<div class='result-container'>";  
            echo "<h4>Oops! The following errors were detected:</h4>";  
            echo "<p>" . $errorMsg . "</p>";  
            echo "<a href='signup.php' class='btn btn-error'>Return to Sign up</a>";  
            echo "</div>";  
        }  
    } else {  
        // Display error message for form validation failures  
        echo "<div class='result-container'>";  
        echo "<h4>Oops! The following errors were detected:</h4>";  
        echo "<p>" . $errorMsg . "</p>";  
        echo "<a href='signup.php' class='btn btn-error'>Return to Sign up</a>";  
        echo "</div>";  
    }  
      
    // Define the saveMemberToDB function  
    function saveMemberToDB($fname, $lname, $email, $pwd_hashed) {  
        global $errorMsg, $success;  
      
        // Create database connection using your config file  
        $config = parse_ini_file('/var/www/private/db-config.ini');  
        if (!$config) {  
            $errorMsg = "Failed to read database config file.";  
            $success = false;  
            return;  
        }  
      
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);  
        if ($conn->connect_error) {  
            $errorMsg = "Connection failed: " . $conn->connect_error;  
            $success = false;  
            return;  
        }  
      
        $stmt = $conn->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password) VALUES (?, ?, ?, ?)");  
        $stmt->bind_param("ssss", $fname, $lname, $email, $pwd_hashed);  
        if (!$stmt->execute()) {  
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;  
            $success = false;  
        }  
      
        $stmt->close();  
        $conn->close();  
    }  
    ?> 
 
    <?php include "inc/footer.inc.php"; ?> 
</body> 
 
 
</html>