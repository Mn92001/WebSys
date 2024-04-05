<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../../inc/db.php'; 

    $errorMsg = $successMsg = "";
    $success = true;
    $reportPdfContent= $reportPdfFileName = $briefReportPdfContent = $briefReportPdfFileName = "";

    // Retrieve hidden input from approve form
    $userID = $_SESSION['user_id'];
    $penReportID = $_SESSION['PenReportID'];
    $submissionDate = date('Y-m-d H:i:s');
    $pentesterID = getPentesterID($conn, $userID);
    
    // 1. Validate and sanitize reportPdf 
    if (isset($_FILES['reportPdf']) && $_FILES['reportPdf']['error'] == 0) {
        $result = processPdfUpload($_FILES['reportPdf']);
        if (!$result) {
            $errorMsg .= "There was an error processing the report PDF or file is too large.";
            $success = false;
        } else {
            $reportPdfContent = $result['content'];
            $reportPdfFileName = $result['name'];
        }
    } else {
        $errorMsg .= "Report PDF is required.";
        $success = false;
    }

    // 2. Validate and sanitize briefReportPdf 
    if (isset($_FILES['briefReportPdf']) && $_FILES['briefReportPdf']['error'] == 0) {
        $result = processPdfUpload($_FILES['briefReportPdf']);
        if (!$result) {
            $errorMsg .= "There was an error processing the brief report PDF or file is too large.";
            $success = false;
        } else {
            $briefReportPdfContent = $result['content'];
            $briefReportPdfFileName = $result['name'];
        }
    } else {
        $errorMsg .= "Brief Report PDF is required.";
        $success = false;
    }

    if($success){
        // Query statement to update the PentesterReport table
        $query = "UPDATE PentesterReport SET ClientApprovalStatus = 'Pending', SubmissionDate = ?, ReportFileName = ?, ReportData = ?, ReportStatus = 'Submitted', BriefReportFileName = ?, BriefReportData = ? WHERE PenReportID = ?";

        // Statement for query
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sssssi", $submissionDate, $reportPdfFileName, $reportPdfContent, $briefReportPdfFileName, $briefReportPdfContent, $penReportID);

            if ($stmt->execute()) {
                // Check if any rows were updated
                if ($stmt->affected_rows > 0) {
                    $successMsg .= "Successfully submitted pentester report. Please wait for the client to approve. ";
                    $_SESSION['success'] = $successMsg;

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

        $queryPentester = "UPDATE Pentester SET NoActiveLockedIn = 0 WHERE PentesterID = ?";

        // Statement for queryPentester
        if ($stmt = $conn->prepare($queryPentester)) {
            $stmt->bind_param("i", $pentesterID);

            if ($stmt->execute()) {
                // Check if any rows were updated
                if ($stmt->affected_rows > 0) {

                    header("Location: ../../index.php");
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

        }
    }
    
    // Close connection
    $conn->close();

    // function to validate and process pdf
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