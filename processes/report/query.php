<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';

    $userID = $_SESSION['user_id'];
    $pentesterID = getPentesterID($conn, $userID);
    $hasLockInRecords = checkForLockInRecords($conn, $pentesterID);
    
    // Query to get pentester report info and findings info
    $query = "
        SELECT 
            lr.PentesterID,
            pr.PenReportID,
            pr.ClientApprovalStatus,
            pr.ReportStatus,
            pr.ReportFileName,
            pr.ReportData,
            GROUP_CONCAT(rf.Description) AS FindingsDescriptions,
            GROUP_CONCAT(rf.SeverityLevel) AS SeverityLevels,
            GROUP_CONCAT(rf.OWASP) AS OWASPs,
            GROUP_CONCAT(rf.CVEDetail) AS CVEDetails
        FROM 
            PentesterReport pr
        JOIN 
            LockInRecord lr ON pr.LockedInID = lr.LockedInID
        LEFT JOIN
            ReportFindings rf ON pr.PenReportID = rf.PenReportID
        WHERE 
            lr.PentesterID = ? AND pr.ReportStatus = 'Pending'
        GROUP BY
            pr.PenReportID;
        ";
        
     // Statement for query
     if ($hasLockInRecords != false && $stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $pentesterID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['PenReportID'] = $row['PenReportID'];

            } 
        }
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

    // function to get the currently locked in records that have not yet been submitted
    function checkForLockInRecords($conn, $pentesterID) {
        $query = "
            SELECT COUNT(lr.LockedInID) AS LockInCount
            FROM LockInRecord lr
            JOIN PentesterReport pr ON pr.LockedInID = lr.LockedInID
            WHERE lr.PentesterID = ? AND pr.ReportStatus = 'Pending';
        ";
    
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $pentesterID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            $stmt->close();
            

            return $row['LockInCount'] > 0;
        }
    
        return false;
    }   
?>  