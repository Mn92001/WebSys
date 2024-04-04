<?php
// Assuming you have already established a database connection
session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';
// Fetch locked-in projects with their details
$sql = "
    SELECT 
        p.ProjectName,
        u.FullName AS Client,
        um.FullName AS Pentester,
        pr.ReportStatus,
        pr.ClientApprovalStatus
    FROM
        Project p
        INNER JOIN LockInRecord l ON p.ProjectID = l.ProjectID
        INNER JOIN Pentester pt ON l.PentesterID = pt.PentesterID
        INNER JOIN PentesterReport pr ON l.LockedInID = pr.LockedInID
        INNER JOIN ApprovalOfPentester ap ON pt.PentesterID = ap.PentesterID
        INNER JOIN Client c ON p.ClientID = c.ClientID
        INNER JOIN UserMaster u ON c.UserID = u.UserID
        INNER JOIN UserMaster um ON pt.UserID = um.UserID

";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    $_SESSION['error'] = "Error retrieving projects: " . $conn->error;
    header("Location: ../pages/adminprojects.php");
    exit;
}

// Close the database connection
$conn->close();

?>
