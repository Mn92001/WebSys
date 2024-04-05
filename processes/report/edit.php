<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../../inc/db.php';

    $userID = $_SESSION['user_id'];

        $query = "UPDATE ReportFindings SET Description = ?, SeverityLevel = ?, OWASP = ?, CVEDetail = ?, WHERE FindingID = ?";  

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("ssssi", $Description, $SeverityLevel, $OWASP, $CVEDetail, $FindingID);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Successfully edited a finding.";
            } else {
                $_SESSION['error'] = "Error updating records: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        }

        

    header("Location: ../../pages/report_submission.php");
    exit;

    // Close connection
    $conn->close();

?> 