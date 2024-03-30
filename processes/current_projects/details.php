<?php


// Include database connection
include '../inc/db.php';


// Check if the error session variable is set
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the session variable
} else {
    // Retrieve user ID from session variables
    $user_id = $_SESSION['user_id'];
}

// Retrieve NoActiveLockedIn using the function
$noActiveLockedIn = retrieveNoActiveLockedIn($conn, $user_id);



    
    // Query to get project info based on ProjectID
    $query = "
        SELECT
            ProjectName,
            ProjectDescription,
            ProjectExpiryDate,
            CoinsOffered,
            ROEFileName,
            ScopeFileName,
            DateOfCompletion
        FROM Project
        WHERE ProjectID = ?
    ";

    // Prepare the query
    if ($stmt = $conn->prepare($query)) {
        // Bind the projectID parameter
        $stmt->bind_param("i", $noActiveLockedIn);

        // Execute the query
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($projectName, $projectDescription, $projectExpiryDate, $coinsOffered, $roeFileName, $scopeFileName, $dateOfCompletion);

        // Fetch the result
        $stmt->fetch();

        // Close the statement
        $stmt->close();
    }

    // Close connection
    $conn->close();




// Function to retrieve NoActiveLockedIn from the database
function retrieveNoActiveLockedIn($conn, $user_id) {
    // Initialize variable
    $noActiveLockedIn = null;

    // SQL query to retrieve the PentesterID from the Pentester table based on the UserID
    $pentesterid_query = "SELECT PentesterID FROM Pentester WHERE UserID = ?";
    $stmt = $conn->prepare($pentesterid_query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the query returned exactly one row
    if ($stmt->num_rows == 1) {
        // Bind the result variable
        $stmt->bind_result($pentesterid);
        // Fetch the result
        $stmt->fetch();

        // Query to retrieve NoActiveLockedIn from Pentester table based on PentesterID
        $noActiveLockedIn_query = "SELECT NoActiveLockedIn FROM Pentester WHERE PentesterID = ?";
        $stmt2 = $conn->prepare($noActiveLockedIn_query);
        $stmt2->bind_param("i", $pentesterid);
        $stmt2->execute();
        $stmt2->store_result();

        // Check if the query returned exactly one row
        if ($stmt2->num_rows == 1) {
            // Bind the result variable
            $stmt2->bind_result($noActiveLockedIn);
            // Fetch the result
            $stmt2->fetch();
        } else {
            echo "NoActiveLockedIn data not found";
        }

        // Close the statement
        $stmt2->close();
    } else {
        echo "Pentester data not found";
    }

    // Close the statement
    $stmt->close();

    // Return the retrieved value
    return $noActiveLockedIn;
}

?>
