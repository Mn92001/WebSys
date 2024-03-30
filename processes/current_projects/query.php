<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';

    $userID = $_SESSION['user_id'];
    $pentesterID = getPentesterID($conn, $userID);

    // Query to get current project info
    $query = "
        SELECT 
            lr.LockedInID,
            lr.LockedInExpiryDate,
            lr.ApprovalStatus,
            lr.ProjectID,
            p.ProjectName, 
            lr.PentesterID
            
        FROM 
            LockInRecord lr
        JOIN 
            Project p ON lr.ProjectID = p.ProjectID

        WHERE 
            lr.PentesterID = ?; 
        ";

        // PentesterReport table not updated, /processes/projects/lockin.php relevant code commented

        // pr.ClientApprovalStatus
        //JOIN 
        //PentesterReport pr ON lr.LockedInID = pr.LockedInID

     // Statement for query
     if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $pentesterID);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
     }

    // Close connection
    $conn->close();


    // function to get pentester ID
    function getPentesterID($conn, $userID){
        $queryPentester = "SELECT PentesterID FROM Pentester WHERE UserID = ?";
        $pentesterID = 0;

        // Statement for queryPentester to get the pentesterID
        if ($stmt = $conn->prepare($queryPentester)) {
            $stmt->bind_param("i", $userID);
            $stmt->execute();
    
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pentesterID = $row['PentesterID']; 
            } 
    
            $stmt->close();
        } 
    
        return $pentesterID;
    }
?>        
