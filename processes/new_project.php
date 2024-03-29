<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();



if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); 
} else {
    // Retrieve user information from session variables
    $user_id = $_SESSION['user_id'];
    }

include '../inc/db.php';

    $clientid_query = "SELECT ClientID FROM Client WHERE UserID = ?";
    $stmt = $conn->prepare($clientid_query);
    $stmt->bind_param("s", $user_id); // Assuming 'username' is the column in clients table
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($clientid);
        $stmt->fetch();
        
        // Assign additional data to session variable
        $_SESSION['client_id'] = $clientid;
    } else {
        echo "Client data not found";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();



// Initialize variables to store form data and error messages 
$name = $description = $expiryDate = $coinsOffered = $completionDate = ""; 
$roePdfContent = $roePdfFileName = $scopePdfContent = $scopePdfFileName = "";
$errorMsg = ""; 
$availabilityStatus = "Available";
$projectStatus = "NotStarted";
$clientID = $_SESSION['client_id'];
$success = true; 

// Helper function to sanitize input 
function sanitize_input($data) 
{ 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data; 
} 



// 1. Validate and sanitize project name 
if (empty($_POST["name"])) { 
    $errorMsg .= "Project name is required."; 
    $success = false; 
} else { 
    $name = sanitize_input($_POST["name"]); 
    // Define the regular expression for allowed characters (letters, numbers, underscores)
    if (!preg_match('/^\w+$/', $name)) {
        $errorMsg .= "Project name can only contain letters, numbers, and underscores.";
        $success = false;
    }
} 

// 2. Validate and sanitize project description
if (empty($_POST["description"])) { 
    $errorMsg .= "Project description is required."; 
    $success = false; 
} else { 
    $description = sanitize_input($_POST["description"]); 
    if (!preg_match('/^[\w\s]+$/', $description)) {
        $errorMsg .= "Project description can only contain letters, numbers, and underscores.";
        $success = false;
    }
} 

// 3. Validate and sanitize coinsOffered 
if (!empty($_POST["coinsOffered"])) { 
    $coinsOffered = sanitize_input($_POST["coinsOffered"]); 

    if (!preg_match('/^\+?[0-9]+$/', $coinsOffered)) {
        $errorMsg .= "Invalid phone number format."; 
        $success = false; 
    }
} 

// 4. Validate and sanitize expiry date
if (empty($_POST["expiryDate"])) { 
    $errorMsg .= "Expiry date is required."; 
    $success = false; 
} else { 
    $expiryDate = sanitize_input($_POST["expiryDate"]); 
    // Perform validation
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiryDate)) {
        $errorMsg .= "Invalid expiry date format."; 
        $success = false; 
    }
} 

// 5. Validate and sanitize completion date
if (empty($_POST["completionDate"])) { 
    $errorMsg .= "Completion date is required."; 
    $success = false; 
} else { 
    $completionDate = sanitize_input($_POST["completionDate"]); 
    // Perform validation
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $completionDate)) {
        $errorMsg .= "Invalid completion date format."; 
        $success = false; 
    }
} 


 // 6. Validate and sanitize roePdf 
     if (isset($_FILES['roePdf']) && $_FILES['roePdf']['error'] == 0) {
    $result = processPdfUpload($_FILES['roePdf']);
    if (!$result) {
         $errorMsg .= "There was an error processing the roe PDF or file is too large.";
         $success = false;
     } else {
         $roePdfContent = $result['content'];
         $roePdfFileName = $result['name'];
     }
 } else {
     $errorMsg .= "Roe PDF is required.";
     $success = false;
}

 // 7. Validate and sanitize scopePdf 
 if (isset($_FILES['scopePdf']) && $_FILES['scopePdf']['error'] == 0) {
     $result = processPdfUpload($_FILES['scopePdf']);
     if (!$result) {
         $errorMsg .= "There was an error processing the scope PDF or file is too large.";
         $success = false;
     } else {
         $scopePdfContent = $result['content'];
         $scopePdfFileName = $result['name'];
     }
 } else {
     $errorMsg .= "Scope PDF is required.";
     $success = false;
 }


if ($success) {  
    // Save the user to the database and get the user id
    saveUserPentesterToDB($name, $description, $expiryDate, $completionDate, $coinsOffered, $roePdfContent, $roePdfFileName, $scopePdfContent, $scopePdfFileName, $availabilityStatus, $projectStatus, $clientID);  
    
    if ($success) {  
        $_SESSION['success'] = "Project Added.";

        header("Location: ../index.php");
        exit;  
        } else {  

            $_SESSION['error'] = $errorMsg;
            header("Location: ../pages/login.php"); 
            exit;
        }  

} else {  
    $_SESSION['error'] = $errorMsg; 
    header("Location: ../pages/new_project.php"); 
    exit;
}  

function processPdfUpload($file) {
    $maxFileSize = 5 * 1024 * 1024;

    if ($file['type'] != 'application/pdf') {
        return false;
    }

    // Check file size
    if ($file['size'] > $maxFileSize) {
        // File is too large
        return false;
    }

    $pdfContent = file_get_contents($file['tmp_name']);
    if ($pdfContent === false) {
        return false; 
    }

    return ['content' => $pdfContent, 'name' => $file['name']];
}


// Define the saveUserPentesterToDB function
function saveUserPentesterToDB($name, $description, $expiryDate, $completionDate, $coinsOffered, $roePdfContent, $roePdfFileName, $scopePdfContent, $scopePdfFileName, $availabilityStatus, $projectStatus, $clientID) {
    global $errorMsg, $success;

    include '../inc/db.php';

    $stmt = $conn->prepare("INSERT INTO Project (ProjectName, ProjectDescription, ProjectExpiryDate, CoinsOffered, AvaliabilityStatus, ProjectStatus, ROEFileName, ROEData, ScopeFileName, ScopeData, DateOfCompletion, ClientID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "SQL prepare error: " . $conn->error;
    }

    if (!$stmt->bind_param("sssisssssssi", $name, $description, $expiryDate, $coinsOffered, $availabilityStatus, $projectStatus, $roePdfFileName, $roePdfContent, $scopePdfFileName, $scopePdfContent, $completionDate, $clientID)) {
        echo "Parameter binding error: " . $stmt->error;
    }

    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    } else {
        // Increment project count in the Client table
        $updateStmt = $conn->prepare("UPDATE Client SET Projects = Projects + 1 WHERE ClientID = ?");
        if (!$updateStmt) {
            echo "SQL prepare error: " . $conn->error;
        }

        if (!$updateStmt->bind_param("i", $clientID)) {
            echo "Parameter binding error: " . $updateStmt->error;
        }

        if (!$updateStmt->execute()) {
            $errorMsg = "Execute failed: (" . $updateStmt->errno . ") " . $updateStmt->error;
            $success = false;
        }

        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();
}
?> 