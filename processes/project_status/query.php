<?php
session_start();

include '../../inc/db.php';

// Check if the error session variable is set
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the session variable
} else {
    // Retrieve user ID from session variables
    $user_id = $_SESSION['user_id'];
}

// Retrieve NoActiveLockedIn using the function
$clientID = retrieveClientID($conn, $user_id);

// Query to get project info
$query = "
    SELECT
        ProjectID,
        ProjectName,
        ProjectDescription,
        ProjectExpiryDate,
        CoinsOffered,
        ROEFileName,
        ScopeFileName,
        DateOfCompletion,
        ProjectStatus
    FROM Project
    WHERE ClientID = ?;
";

// Statement for query
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $clientID);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();
} else {
    $error_msg = "Error preparing SQL query: " . $conn->error;
    error_log($error_msg);
}

$conn->close();

// Function to retrieve NoActiveLockedIn from the database
function retrieveClientID($conn, $user_id) {
    // Initialize variable
    $clientid = null;

    // SQL query to retrieve the ClientID from the Client table based on the UserID
    $clientid_query = "SELECT ClientID FROM Client WHERE UserID = ?";
    $stmt = $conn->prepare($clientid_query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the query returned exactly one row
    if ($stmt->num_rows == 1) {
        // Bind the result variable
        $stmt->bind_result($clientid);
        // Fetch the result
        $stmt->fetch();
    } else {
        $error_msg = "Client data not found for UserID: " . $user_id;
        error_log($error_msg);
    }

    // Close the statement
    $stmt->close();

    // Return the retrieved value
    return $clientid;
}
?>
