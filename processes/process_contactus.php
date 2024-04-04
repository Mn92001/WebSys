<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$success = true;
$errorMsg = '';

// Helper function to sanitize input 
function sanitize_input($data) 
{ 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data; 
} 

// 1. Validate and sanitize fullname 
if (empty($_POST["name"])) { 
    $errorMsg .= "Name is required.<br>"; 
    $success = false; 
} else { 
    $name = sanitize_input($_POST["name"]);  // Corrected capitalization from "Name"
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errorMsg .= "Name must contain only letters and spaces.";
        $success = false;
    }
} 

// 2. Validate and sanitize email 
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

// 3. Validate and sanitize message
if (empty($_POST["message"])) { 
    $errorMsg .= "Message is required."; 
    $success = false; 
} else { 
    $message = sanitize_input($_POST["message"]); 
    if (!preg_match('/^[\w\s]+$/', $message)) {
        $errorMsg .= "message can only contain letters, numbers, and underscores.";
        $success = false;
    }
} 

if ($success) {  
    // Save the user to the database and get the user id
    $userID = saveEnquiryToDB($name, $email, $message);  
    
    if ($success) {  
        $_SESSION['success'] = "Enquiry has been sent.";
        header("Location: ../index.php");
        exit;  
    } else {  
        $_SESSION['error'] = $errorMsg;
        header("Location: ../pages/contact_us.php"); 
        exit;
    }  
} else {  
    $_SESSION['error'] = $errorMsg; 
    header("Location: ../pages/contact_us.php"); 
    exit;
}  

// Define the saveUserClientToDB function  
function saveEnquiryToDB($name, $email, $message) {  
    global $errorMsg, $success;  

    include '../inc/db.php';
 
    $stmt = $conn->prepare("INSERT INTO Enquiries (Name, Email, Message) VALUES (?, ?, ?)");  
    $stmt->bind_param("sss", $name, $email, $message);  
     
    if (!$stmt->execute()) {  
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;  
        $success = false;  
    }

    $stmt->close();  
    $conn->close();  
}  
?>
