<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $errorMsg = "";

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

            // Login checks for pentesters
            if ($role == 'Pentester') {
                $approvalStatus = checkApprovalOfPentester($conn, $row['UserID']);
                // Handle not approved case
                if ($approvalStatus == "Pending") {                  
                    // Pentester account not yet approved
                    $errorMsg .= "Your account has not been approved. Please wait for an administrator to approve your account or contact support.";
                    $_SESSION['error'] = $errorMsg;

                    // Option to return to login page
                     header("Location: ../pages/login.php");
                     exit;
                } else if ($approvalStatus == "Rejected"){
                    // Pentester account rejected
                    $errorMsg .= "Your registration has been rejected. Please contact support if you have queries.";
                    $_SESSION['error'] = $errorMsg;

                    // Option to return to login page
                     header("Location: ../pages/login.php");
                     exit;
                } else if ($approvalStatus == "Suspended"){
                    // Pentester account suspended
                    $errorMsg .= "Your account has been suspended. Please contact support if you have queries.";
                    $_SESSION['error'] = $errorMsg;

                    // Option to return to login page
                     header("Location: ../pages/login.php");
                     exit;
                } else {
                    $is2FAEnabled = check2FAEnabled($conn, $username);

                    if ($is2FAEnabled) {
                        session_start(); 
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $row['Role'];
                        $_SESSION['user_id'] = $row['UserID'];
                        header('Location: ../pages/login_2fa.php');
                        exit;
                    } else {
                        // Start session after successful login
                        session_start(); 
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $row['Role'];
                        $_SESSION['user_id'] = $row['UserID'];
                        $_SESSION['success'] = "Login successful.";
                        $_SESSION['approved'] = "Approved";

                        // Option to return to home page
                        header("Location: ../index.php");
                        exit;
                    }   
                }
            } else {

                $is2FAEnabled = check2FAEnabled($conn, $username);

                if ($is2FAEnabled) {
                    session_start(); 
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $row['Role'];
                    $_SESSION['user_id'] = $row['UserID'];
                    header('Location: ../pages/login_2fa.php.php');
                    exit;
                } else {
                    // Start session after successful login
                    session_start(); 
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $row['Role'];
                    $_SESSION['user_id'] = $row['UserID'];
                    $_SESSION['success'] = "Login successful.";


                    // Option to return to home page
                    header("Location: ../index.php");
                    exit;
                }             
            }           
        } else {
            // Password incorrect
            session_start();
            $errorMsg .= "Password is incorrect.";
            $_SESSION['error'] = $errorMsg; 
            header("Location: ../pages/login.php"); 
            exit;
        }
    } else {
        // User not found
        session_start();
        $errorMsg .= "Account not found.";
        $_SESSION['error'] = $errorMsg; 
        header("Location: ../pages/login.php"); 
        exit;
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
            // Get the first row
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

    function check2FAEnabled($conn, $username){
        $query2fa = "SELECT TwoFactorEnabled FROM UserMaster WHERE Username = ?";

        if($stmt = $conn->prepare($query2fa)){

            $stmt->bind_param("s", $username); 

            if(!$stmt->execute()){
                $stmt->close();
                return false;
            } else {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close(); 
                return $row['TwoFactorEnabled'] == 1;
            }            
        } else {
            return false;
        }
    }
    
    ?>

