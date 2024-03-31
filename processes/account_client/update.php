<?php
// update.php

session_start();

include '../../inc/db.php'; 

$userID = $_SESSION['user_id'];

function sanitize_input($data) 
{ 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data; 
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_type = $_POST["update_type"];
    $errorMsg = "";
    $success = true;

    // Handle different update types
    switch ($update_type) {
        case "email":
            // Handle email update

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
            // Update email for the user
            $stmt = $conn->prepare("UPDATE UserMaster SET Email = ? WHERE UserID = ?");
            $stmt->bind_param("si", $email, $userID);
            $stmt->execute();
            if ($stmt->affected_rows === 0) {
                $errorMsg = "Failed to update email.";
                $success = false;
            }
            $stmt->close();
            break;

        case "number":
            // Handle phone number update
            if (!empty($_POST["phoneNumber"])) { 
                $phoneNumber = sanitize_input($_POST["phoneNumber"]); 
        
                if (!preg_match('/^\+?[0-9]+$/', $phoneNumber)) {
                    $errorMsg .= "Invalid phone number format."; 
                    $success = false; 
                } else {
                    // Update phone number for the user
                    $stmt = $conn->prepare("UPDATE UserMaster SET PhoneNumber = ? WHERE UserID = ?");
                    $stmt->bind_param("si", $phoneNumber, $userID);
                    $stmt->execute();
                    if ($stmt->affected_rows === 0) {
                        $errorMsg = "Failed to update phone number.";
                        $success = false;
                    }
                    $stmt->close();
                }
            } 
            break;

        case "password":
            // Handle password update
            $pwd = isset($_POST["pwd"]) ? $_POST["pwd"] : "";
            $pwd_confirm = isset($_POST["pwd_confirm"]) ? $_POST["pwd_confirm"] : "";

            if (empty($pwd)) { 
                $errorMsg .= "Password is required."; 
                $success = false; 
            } elseif (empty($pwd_confirm)) { 
                $errorMsg .= "Confirm Password is required."; 
                $success = false; 
            } elseif ($pwd !== $pwd_confirm) { 
                $errorMsg .= "Passwords do not match."; 
                $success = false; 
            } else { 
                $strongPasswordRegex = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}/";
                if (!preg_match($strongPasswordRegex, $pwd)) {
                    $errorMsg .= "Password must contain at least 8 characters, including at least one number, one uppercase letter, one lowercase letter, and one special character."; 
                    $success = false; 
                } else {
                    // Hash the password
                    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
                    // Update password for the user
                    $stmt = $conn->prepare("UPDATE UserMaster SET Password = ? WHERE UserID = ?");
                    $stmt->bind_param("si", $pwd_hashed, $userID);
                    $stmt->execute();
                    if ($stmt->affected_rows === 0) {
                        $errorMsg = "Failed to update password.";
                        $success = false;
                    }
                    $stmt->close();
                }
            } 
            break;

        case "delete":
            // Handle account deletion
                $stmt = $conn->prepare("DELETE FROM UserMaster WHERE UserID = ?");
                $stmt->bind_param("i", $userID);
                
                // Execute the DELETE statement
                if (!$stmt->execute()) {
                    // Error occurred during execution
                    $errorMsg = "Error deleting record: " . $stmt->error;
                    $success = false;
                } else {
                    // Check if any rows were affected
                    if ($stmt->affected_rows === 0) {
                        $errorMsg = "No rows deleted. User ID might not exist.";
                        $success = false;
                    } else {
                        // Deletion successful
                        session_destroy();
                        header("Location: ../../index.php");
                        exit;
                    }
                }

                // Close the statement
                $stmt->close();
            break;


            case "coins":
                // Handle coins top-up
                    if (!empty($_POST["coins"])) {
                        $coins = sanitize_input($_POST["coins"]);
                
                        // Ensure coins is a positive integer
                        if (!is_numeric($coins) || $coins <= 0 || floor($coins) != $coins) {
                            $errorMsg .= "Invalid coins value. Coins must be a positive integer.";
                            $success = false;
                        } else {
                            // Update total coins for the user
                            $stmt = $conn->prepare("UPDATE UserMaster SET TotalCoins = TotalCoins + ? WHERE UserID = ?");
                            $stmt->bind_param("ii", $coins, $userID);
                            $stmt->execute();
                            if ($stmt->affected_rows === 0) {
                                $errorMsg = "Failed to update coins.";
                                $success = false;
                            }
                            $stmt->close();
                        }
                    } else {
                        $errorMsg .= "Coins value is required.";
                        $success = false;
                    }
                break;
            


        default:
            // Handle unknown update type
            break;
    }

    // Close the database connection
    $conn->close();

    // Redirect based on success or failure
    if ($success) {  
        $_SESSION['success'] = "Update successful.";
        header("Location: ../../index.php");
        exit;  
    } else {  
        $_SESSION['error'] = $errorMsg;
        header("Location: ../../pages/accountclient.php"); 
        exit;
    }
} else {  
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../../pages/accountclient.php"); 
    exit;
}
?>
