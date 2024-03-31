<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php'; 

    $errorMsg = $successMsg = "";
    $success = true;

    // Retrieve hidden input from approve form
    if (!isset($_SESSION['user_id'], $_SESSION['receiverRole'], $_SESSION['projectid'])) {
        // Redirect or handle error
        exit('Session variables not set correctly.');
    }

    // Retrieve hidden input from approve form
    $userID = $_SESSION['user_id'];
    $receiverRole = $_SESSION['receiverRole'];
    
    unset($_SESSION['receiverRole']);

    // client's transactions
    if ($_SESSION['role'] == 'Client'){
        
        // client to pentester
        if ($receiverRole == 'Pentester'){
            $projectID = $_SESSION['projectid'];
            unset($_SESSION['projectid']);
            // Query statement
            // Retrieve the client's project info, client's info, and pentester's info
                $queryProject = "
                    SELECT 
                        umClient.UserID AS SenderID, 
                        umClient.TotalCoins AS SenderTotalCoins,
                        umPentester.UserID AS ReceiverID,
                        umPentester.TotalCoins AS ReceiverTotalCoins,
                        p.ProjectID,
                        p.CoinsOffered,
                        p.ProjectStatus,
                        p.DateOfCompletion,
                        pr.ClientApprovalStatus,
                        pr.LockedInID
                    FROM 
                        Project p
                    JOIN 
                        LockInRecord lr ON lr.ProjectID = p.ProjectID
                    JOIN
                        PentesterReport pr ON pr.LockedInID = lr.LockedInID
                    JOIN 
                        Pentester pen ON lr.PentesterID = pen.PentesterID
                    JOIN 
                        UserMaster umPentester ON pen.UserID = umPentester.UserID
                    JOIN 
                        UserMaster umClient ON umClient.UserID = ?
                    WHERE 
                        p.ProjectID = ?;";  
                
                // Statement for query
            if ($stmt0 = $conn->prepare($queryProject)) {
                $stmt0->bind_param("ii", $userID, $projectID);

                if ($stmt0->execute()) {
                    $result = $stmt0->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        
                        // (1) Check if theres sufficient coins in client account
                        if($row['SenderTotalCoins'] <  $row['CoinsOffered']){
                            $_SESSION['error'] = "Insufficient coins. Transaction cancelled";
                            $success = false;

                            header("Location: ../index.php");
                            exit;
                        } else {
                            $transactionDetails = [
                                'coins' => $row['CoinsOffered'], 
                                'senderid' => $row['SenderID'],
                                'receiverid' => $row['ReceiverID'],
                                'projectid' => $row['ProjectID'],
                                'type' => 'ClientToPentester',
                                ];

                            $fieldsToUpdate = [
                                'coins' => $row['CoinsOffered'], 
                                'projectid' => $row['ProjectID'],
                                'projectStatus' => 'Completed', 
                                'dateOfCompletion' => date("Y-m-d H:i:s"),
                                'reportStatus' => 'Approved',
                                'senderCoins' => $row['SenderTotalCoins'],
                                'receiverCoins' => $row['ReceiverTotalCoins'],
                                'senderid' => $row['SenderID'],
                                'receiverid' => $row['ReceiverID'],
                                'lockedinID' => $row['LockedInID'],
                                ];
                        }
                    } 
                }
                $stmt0->close();
            }            
        }  
        
        if($success){
            saveTransaction($conn, $transactionDetails['coins'], $transactionDetails['senderid'], $transactionDetails['receiverid'], $transactionDetails['projectid'], $transactionDetails['type']);
            updateFields($conn, $fieldsToUpdate['projectid'], $fieldsToUpdate['projectStatus'], $fieldsToUpdate['dateOfCompletion'], $fieldsToUpdate['reportStatus'], $fieldsToUpdate['senderCoins'], $fieldsToUpdate['receiverCoins'], $fieldsToUpdate['senderid'], $fieldsToUpdate['receiverid'], $fieldsToUpdate['coins'], $fieldsToUpdate['lockedinID']);
            if ($success) {  
                $_SESSION['success'] = "Payment successful. Please go to 'Project Status' page to download the full report.";
        
                header("Location: ../index.php");
                exit;  
            } else {  
    
                $_SESSION['error'] = $errorMsg;
                header("Location: ../index.php"); 
                exit;
            }  
        } else{
            $_SESSION['error'] = $errorMsg; 
            header("Location: ../index.php"); 
            exit;
        }
    }

    // Close connection
    $conn->close();

    // Define the saveUserPentesterToDB function  
function saveTransaction($conn, $coins, $senderid, $receiverid, $projectid, $type) {  
    global $errorMsg, $success;  

    $stmt = $conn->prepare("INSERT INTO Transaction (NoOfCoins, SenderID, ReceiverID, ProjectID, TransactionType) VALUES (?, ?, ?, ?, ?)");  
    $stmt->bind_param("iiiis", $coins, $senderid, $receiverid, $projectid, $type);  
     
    if (!$stmt->execute()) {  
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;  
        $success = false;  
    } 

    $stmt->close();   
}  

function updateFields($conn, $projectid, $projectStatus, $dateOfCompletion, $reportStatus, $senderCoins, $receiverCoins, $senderid, $receiverid, $coinsOffered, $lockedinID) {  
    global $errorMsg, $success;  

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Update project
        $stmt1 = $conn->prepare("UPDATE Project SET ProjectStatus = ?, DateOfCompletion = ? WHERE ProjectID = ?");
        if (!$stmt1) throw new Exception("Prepare failed: " . $conn->error);
        $stmt1->bind_param("ssi", $projectStatus, $dateOfCompletion, $projectid);
        if (!$stmt1->execute()) throw new Exception("Execute failed: " . $stmt1->error);

        // Update client's coin
        $newSenderCoins = $senderCoins - $coinsOffered;
        $stmt2 = $conn->prepare("UPDATE UserMaster SET TotalCoins = ? WHERE UserID = ?");
        if (!$stmt2) throw new Exception("Prepare failed: " . $conn->error);
        $stmt2->bind_param("ii", $newSenderCoins, $senderid);
        if (!$stmt2->execute()) throw new Exception("Execute failed: " . $stmt2->error);

        // Update pentester's coin
        $newReceiverCoins = $receiverCoins + $coinsOffered;
        $stmt3 = $conn->prepare("UPDATE UserMaster SET TotalCoins = ? WHERE UserID = ?");
        if (!$stmt3) throw new Exception("Prepare failed: " . $conn->error);
        $stmt3->bind_param("ii", $newReceiverCoins, $receiverid);
        if (!$stmt3->execute()) throw new Exception("Execute failed: " . $stmt3->error);

        // Update PentesterReport Status
        $stmt4 = $conn->prepare("UPDATE PentesterReport SET ClientApprovalStatus = ? WHERE LockedInID = ?");
        if (!$stmt4) throw new Exception("Prepare failed: " . $conn->error);
        $stmt4->bind_param("si", $reportStatus, $lockedinID);
        if (!$stmt4->execute()) throw new Exception("Execute failed: " . $stmt4->error);

        // Commit the transaction
        $conn->commit();

    } catch (Exception $e) {
        // Rollback the transaction on any error
        $conn->rollback();
        $errorMsg = $e->getMessage();
        $success = false;
    } finally {
        // Close all statements
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        if (isset($stmt4)) $stmt4->close();
    }
} 
?>