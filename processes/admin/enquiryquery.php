<?php
// Assuming you have already established a database connection
session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';
// Fetch locked-in projects with their details
$sql = "
    SELECT 
        Name,
        Email,
        Message
    FROM
        Enquiries

";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    $_SESSION['error'] = "Error retrieving projects: " . $conn->error;
    header("Location: ../pages/enquiry.php");
    exit;
}

// Close the database connection
$conn->close();

?>
