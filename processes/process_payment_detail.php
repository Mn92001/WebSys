<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php'; 

    $errorMsg = $successMsg = "";
    $success = true;

    // Retrieve hidden input from approve form
    $userID = $_SESSION['user_id'];
    $receiver = $_POST["receiver"];
     
    // client's transactions
    if ($_SESSION['role'] == 'Client'){
        
        // client to pentester
        if ($receiver == 'Pentester'){
            $projectID = $_POST["projectID"];
            
            // Query statement
            // Retrieve the client's project info, client's info, and pentester's info
                $queryProject = "
                    SELECT 
                        umClient.UserID AS SenderID, 
                        umClient.Username AS SenderUserName,
                        umClient.TotalCoins AS SenderTotalCoins,
                        umPentester.UserID AS ReceiverID,
                        umPentester.TotalCoins AS ReceiverTotalCoins,
                        umPentester.Username AS ReceiverUserName,
                        umPentester.Role AS ReceiverRole,
                        p.ProjectID,
                        p.CoinsOffered
                    FROM 
                        Project p
                    JOIN 
                        LockInRecord lr ON lr.ProjectID = p.ProjectID
                    JOIN 
                        Pentester pen ON lr.PentesterID = pen.PentesterID
                    JOIN 
                        UserMaster umPentester ON pen.UserID = umPentester.UserID
                    JOIN 
                        UserMaster umClient ON umClient.UserID = ?
                    WHERE 
                        p.ProjectID = ?;";  
                
            // Statement for queryProject
            if ($stmt = $conn->prepare($queryProject)) {
                $stmt->bind_param("ii", $userID, $projectID);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        $_SESSION['details'] = $row; 

                        header('Location: ../pages/payment.php');
                        exit;
                    } 
                }
                $stmt->close();
            }                       
        }        
    }

    // Close connection
    $conn->close(); 
?>