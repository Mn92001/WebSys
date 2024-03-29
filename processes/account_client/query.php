<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';

    $userID = $_SESSION['user_id'];

    // Query to get current project info
    $query = "
        SELECT 
            um.UserID,
            um.Username,
            um.FullName,
            um.Email,
            um.PhoneNumber,
            um.Role,
            um.TotalCoins,
            c.Projects
            
        FROM 
            Client c
        JOIN 
            UserMaster um ON um.UserID = c.UserID

        WHERE 
            um.UserID = ?; 
        ";


     // Statement for query
     if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
     }

    // Close connection
    $conn->close();


?>        
