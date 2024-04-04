<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../../inc/db.php';

    $userID = $_SESSION['user_id'];
    $findingID = $_POST['findingID'];
    $description = $_POST['description'];
    $severityLevel = $_POST['severityLevel'];
    $owasp = $_POST['owasp'];
    $cveDetail = $_POST['cveDetail'];


        $query = "UPDATE ReportFindings SET Description = ?, SeverityLevel = ?, OWASP = ?, CVEDetail = ? WHERE FindingID = ?";  

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("ssssi", $description, $severityLevel, $owasp, $cveDetail, $findingID);

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