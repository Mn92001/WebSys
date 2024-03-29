<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';

    $userID = $_SESSION['user_id'];
    $pentesterID = getPentesterID($conn, $userID);

    // Query to get pentester report info and findings info
    $query = "
        SELECT 
            lr.LockedInExpiryDate,
            lr.PentesterID,
            pr.PenReportID,
            pr.ClientApprovalStatus,
            pr.ReportStatus,
            pr.ReportFileName,
            pr.ReportData,
            GROUP_CONCAT(rf.Description) AS FindingsDescriptions,
            GROUP_CONCAT(sl.SeverityLevel) AS SeverityLevels,
            GROUP_CONCAT(sl.OWASP) AS OWASPs,
            GROUP_CONCAT(sl.CVEDetails) AS CVEDetails
        FROM 
            PentesterReport pr
        JOIN 
            LockInRecord lr ON pr.LockedInID = lr.LockedInID
        JOIN
            ReportFindings rf ON pr.PenReportID = rf.PenReportID
        JOIN
            SeverityListing sl ON rf.FindingID = sl.FindingID
        WHERE 
            lr.PentesterID = ?
        GROUP BY
            pr.PenReportID;
        ";

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