<?php
    session_start();

    include '../../inc/db.php';

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
            DateOfCompletion
        FROM Project
        WHERE AvaliabilityStatus = 'Available'
    ";

    $result = $conn->query($query);

    $conn->close();
?>