<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../../inc/db.php';

    $userID = $_SESSION['user_id'];
    $ids = $_POST['findingIDs'] ?? [];
   
    if (!empty($ids)) {

        $ids = array_map('intval', $ids);
        $idsString = implode(',', array_fill(0, count($ids), '?'));
        

        $query = "DELETE FROM ReportFindings WHERE FindingID IN ($idsString)";    
        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {

            $types = str_repeat('i', count($ids));

            $stmt->bind_param($types, ...$ids);

            if ($stmt->execute()) {
            $_SESSION['success'] = "Successfully deleted a finding.";
            } else {

                $_SESSION['error'] = "Error updating records: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        }
        } else {
        $_SESSION['error'] = "No Finding selected.";
        }
        

    header("Location: ../../pages/report_submission.php");
    exit;

    // Close connection
    $conn->close();

?> 