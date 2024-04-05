<?php 
session_start();

// Initialize variables to store form data and error messages 
$username = $pwd = $pwd_confirm = $fullname = $email = $phoneNumber = $pwd_hashed = ""; 
$role = 'Client';
$errorMsg = ""; 
$emailConfirmed = $twoFA = $lockoutEnabled = $accessFailedCount = $totalCoins = 0;
$success = true; 

// Helper function to sanitize input 
function sanitize_input($data) 
{ 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data; 
} 

// 1. Validate and sanitize username 
    if (empty($_POST["username"])) { 
        $errorMsg .= "Username is required."; 
        $success = false; 
    } else { 
        $username = sanitize_input($_POST["username"]); 
        // Define the regular expression for allowed characters (letters, numbers, underscores)
         if (!preg_match('/^\w+$/', $username)) {
        $errorMsg .= "Username can only contain letters, numbers, and underscores.";
        $success = false;
        }
    } 

// 2. Validate and sanitize password 
    if (empty($_POST["pwd"])) { 
        $errorMsg .= "Password is required."; 
        $success = false; 
    } else { 
        $pwd = sanitize_input($_POST["pwd"]); 
        $strongPasswordRegex = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}/";
        if (!preg_match($strongPasswordRegex, $pwd)) {
            $errorMsg .= "Password must contain at least 8 characters, including at least one number, one uppercase letter, one lowercase letter, and one special character."; 
            $success = false; 
        } 
    } 

// 3. Validate and sanitize password confirmation 
    if (empty($_POST["pwd_confirm"])) { 
        $errorMsg .= "Confirm Password is required."; 
        $success = false; 
    } else { 
        $pwd_confirm = sanitize_input($_POST["pwd_confirm"]); 
        $strongPasswordRegex = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}/";
        if (!preg_match($strongPasswordRegex, $pwd_confirm)) {
            $errorMsg .= "Password must contain at least 8 characters, including at least one number, one uppercase letter, one lowercase letter, and one special character."; 
            $success = false; 
        } 
    } 

// 4. Validate and sanitize fullname 
    if (empty($_POST["fullname"])) { 
        $errorMsg .= "Fullname is required.<br>"; 
        $success = false; 
    } else { 
        $fullname = sanitize_input($_POST["fullname"]); 
        if (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
            $errorMsg .= "Full name must contain only letters and spaces.";
            $success = false;
        }
    } 


// 5. Validate and sanitize email 
    if (empty($_POST["email"])) { 
        $errorMsg .= "Email is required."; 
        $success = false; 
    } else { 
        $email = sanitize_input($_POST["email"]); 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $errorMsg .= "Invalid email format."; 
            $success = false; 
        } 
    } 

// 6. Validate and sanitize phoneNumber 
    if (!empty($_POST["phoneNumber"])) { 
        $phoneNumber = sanitize_input($_POST["phoneNumber"]); 

        if (!preg_match('/^\+?[0-9]+$/', $phoneNumber)) {
            $errorMsg .= "Invalid phone number format."; 
            $success = false; 
        }
    } 

// Check if passwords match 
if ($pwd !== $pwd_confirm) { 
    $errorMsg .= "Passwords do not match."; 
    $success = false; 
} 


if ($success) {  
    // Hash the password  
    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);  

    // Save the user to the database and get the user id
    $userID = saveUserClientToDB($username, $pwd_hashed, $fullname, $email, $phoneNumber, $role);  
    
    if ($success) {  
        $_SESSION['user_id'] = $userID;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role; 
        $_SESSION['success'] = "Registration successful and you have logged in.";

        header("Location: ../index.php");
        exit;  
        } else {  

            $_SESSION['error'] = $errorMsg;
            header("Location: ../pages/register.php"); 
            exit;
        }  
} else {  
    $_SESSION['error'] = $errorMsg; 
    header("Location: ../pages/register.php"); 
    exit;
}  

// Define the saveUserClientToDB function  
function saveUserClientToDB($username, $pwd_hashed, $fullname, $email, $phoneNumber, $role) {  
    global $errorMsg, $success;  

    include '../inc/db.php';
 
    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM UserMaster WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Email already exists, so set an error message
        $errorMsg = "Email address already exists. Please use another email.";
        $success = false;
        $stmt->close();
        $conn->close();
        return; 
    }
    $stmt->close();

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM UserMaster WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Email already exists, so set an error message
        $errorMsg = "Username already exists. Please use another username.";
        $success = false;
        $stmt->close();
        $conn->close();
        return; 
    }
    $stmt->close();

    // If the email doesn't exist, proceed with inserting the new user
    $stmt = $conn->prepare("INSERT INTO UserMaster (username, password, fullname, email, phoneNumber, role) VALUES (?, ?, ?, ?, ?, ?)");  
    $stmt->bind_param("ssssss", $username, $pwd_hashed, $fullname, $email, $phoneNumber, $role);  
     
    if (!$stmt->execute()) {  
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;  
        $success = false;  
    } else {
        // Get the last inserted ID
        $userID = mysqli_insert_id($conn);

        // Insert client into Client table with the retrieved UserID
        $stmt = $conn->prepare("INSERT INTO Client (userID, projects) VALUES (?, 0)");  
        $stmt->bind_param("i", $userID); 
     
        if (!$stmt->execute()) {  
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;  
            $success = false;  
        }
    }

    if ($success) {
        return mysqli_insert_id($conn);
    } else {
        return null;
    }

    $stmt->close();  
    $conn->close();  
}  
?>