<?php
//

include '../../inc/db.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); 
} else {
    // Retrieve user information from session variables
    $user_id = $_SESSION['user_id'];
}

$pentesterid_query = "SELECT PentesterID FROM Pentester WHERE UserID = ?";
$stmt = $conn->prepare($pentesterid_query);
$stmt->bind_param("s", $user_id); 
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($pentesterid);
    $stmt->fetch();
    
    // Assign additional data to session variable
    $_SESSION['pentester_id'] = $pentesterid;
} else {
    echo "Pentester data not found";
}
$stmt->close();

$pentesterID = $_SESSION['pentester_id'];
$errorMsg = $successMsg = "";
$lockedInDate = date("Y-m-d H:i:s"); 


include "query.php";
include '../../inc/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve project_id and project_expiry_date from the form submission
    $projectID = $_POST['project_id'];
    $lockedInExpiryDate = $_POST['project_expiry_date'];

        // Query statement to update the LockInRecord table
        $query = "INSERT INTO LockInRecord (LockedInDate, LockedInExpiryDate, ProjectID, PentesterID) VALUES (?, ?, ?, ?)";

        // Statement for query
        if ($stmt2 = $conn->prepare($query)) {
            $stmt2->bind_param("ssii", $lockedInDate, $lockedInExpiryDate, $projectID, $pentesterID);

            if ($stmt2->execute()) {
                // Check if any rows were updated
                if ($stmt2->affected_rows > 0) {
                    $lockInRecordID = $stmt2->insert_id;
                    $successMsg .= "The project has been locked in.";
                    $_SESSION['success'] = $successMsg;
                    $_SESSION['approved'] = "Approved";

                    // Update the Pentester table with the lockInRecordID
                    $updateQuery = "UPDATE Pentester SET NoActiveLockedIn = ? WHERE PentesterID = ?";
                    $stmt3 = $conn->prepare($updateQuery);
                    $stmt3->bind_param("ii", $lockInRecordID, $pentesterID);
                    if ($stmt3->execute()) {
                        // Update the Projects table with the status
                        $updateProjectQuery = "UPDATE Project SET AvaliabilityStatus = 'Taken', ProjectStatus = 'In-progress' WHERE ProjectID = ?";
                        $stmt4 = $conn->prepare($updateProjectQuery);
                        $stmt4->bind_param("i", $projectID);
                        if ($stmt4->execute()) {

                            //No default value for rest of the columns, wat values to assign?
                            
                            //$insertPentesterReportQuery = "INSERT INTO PentesterReport (LockedInID) VALUES (?)";
                            //$stmt5 = $conn->prepare($insertPentesterReportQuery);
                            //$stmt5->bind_param("i", $lockInRecordID);
                            //if ($stmt5->execute()) {
                                // Redirect to index.php or another page
                            //    header("Location: ../../index.php");
                             //   exit;
                            //} else {
                            //    $errorMsg .= "Failed to insert LockedInID into PentesterReport table.";
                            //}
                            //$stmt5->close(); // Close the fifth prepared statement
                            // Redirect to index.php or another page
                            header("Location: ../../pages/projects.php");
                            exit;
                        } else {
                            $errorMsg .= "Failed to update Project table.";
                            $_SESSION['error'] = $errorMsg;
                            header("Location: ../../pages/projects.php");
                            exit;
                        }
                        $stmt4->close(); // Close the fourth prepared statement
                    } else {
                        $errorMsg .= "Failed to update Pentester table with lockInRecordID.";
                        $_SESSION['error'] = $errorMsg;
                        header("Location: ../../pages/projects.php");
                        exit;
                    }
                    $stmt3->close(); // Close the third prepared statement
                } else {
                    $errorMsg .= "No changes were made. Check if the Pentester ID is correct.";
                    $_SESSION['error'] = $errorMsg;
                    header("Location: ../../pages/projects.php");
                    exit;
                }
            } else {
                $errorMsg .= "ERROR: Could not execute query: $query. " . $conn->error;
                $_SESSION['error'] = $errorMsg;
                header("Location: ../../pages/projects.php");
                exit;
            }

            $stmt2->close(); // Close the second prepared statement

        } else {
            $errorMsg .= "ERROR: Could not prepare query: $query. " . $conn->error;
            $_SESSION['error'] = $errorMsg;
            header("Location: ../../pages/projects.php");
            exit;
        }
     // End of while loop
} else {
    // Handle the case where the form was not submitted
    header("Location: ../../pages/projects.php");
    echo "Form not submitted!";
}// End of if statement
// Close connection
$conn->close();
?>
