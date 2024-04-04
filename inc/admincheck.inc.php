<?php
session_start();
$role = $_SESSION['role'];

if (isset($_SESSION['approved'])) {
        $status = $_SESSION['approved'];
} 

if ($role !== 'Admin') {
    // Redirect to the index.php page
    $errorMsg .= "You must be an admin to access this page.";
    $_SESSION['error'] = $errorMsg;
    header("Location: ../index.php");
    exit(); 
}
?>