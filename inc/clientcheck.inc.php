<?php
session_start();
$role = $_SESSION['role'];

if (isset($_SESSION['approved'])) {
        $status = $_SESSION['approved'];
} 

if ($role !== 'Client') {
    // Redirect to the index.php page
    $errorMsg .= "Please log in as a client first.";
    $_SESSION['error'] = $errorMsg;
    header("Location: ../index.php");
    exit(); 
}
?>