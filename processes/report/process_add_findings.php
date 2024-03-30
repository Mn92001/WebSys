<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include '../../inc/db.php'; 

    $errorMsg = $successMsg = "";

    // Retrieve hidden input from approve form
    $userID = $_SESSION['user_id'];
    $description = $_POST['description'];
    $severityLevel = $_POST['severityLevel'];
    $owasp = $_POST['owasp'];
    $cveDetail = $_POST['cveDetail'];
    $penReportID = $_SESSION['PenReportID'];
    $pentesterID = getPentesterID($conn, $userID);
    
    // Query statement to insert into the ReportFindings table
    $query = "INSERT INTO ReportFindings (Description, SeverityLevel, OWASP, CVEDetail, PenReportID) VALUES (?, ?, ?, ?, ?)";

    // Statement for query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssi", $description, $severityLevel, $owasp, $cveDetail, $penReportID);

        if ($stmt->execute()) {
            // Check if any rows were updated
            if ($stmt->affected_rows > 0) {
                $successMsg .= "Successfully added a finding.";
                $_SESSION['success'] = $successMsg;

                header("Location: ../../pages/report_submission.php");
                exit;

            } else {
                $errorMsg .= "No changes were made.";
                $_SESSION['error'] = $errorMsg;

                header("Location: ../../pages/report_submission.php");
                exit;
            }
        } else {
            $errorMsg .= "ERROR: Could not execute query: $query. " . $conn->error;
            $_SESSION['error'] = $errorMsg;

            header("Location: ../../pages/report_submission.php");
            exit;
        }

        $stmt->close();

    } else {
        $errorMsg .= "ERROR: Could not prepare query: $query. " . $conn->error;
        $_SESSION['error'] = $errorMsg;

        header("Location: ../../pages/report_submission.php");
        exit;
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