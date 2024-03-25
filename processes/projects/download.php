<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../inc/db.php'; 

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type']; 
    $id = intval($_GET['id']); 

    // Retrieve the file information based on the type
    if ($type === 'roe') {
        $query = "SELECT ROEData, ROEFileName FROM Project WHERE ProjectID = ?";
    } else {
        $query = "SELECT ScopeData, ScopeFileName FROM Project WHERE ProjectID = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($data, $filename);
        $stmt->fetch();

        // Set headers for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($data));
        ob_clean(); 
        flush(); 
        echo $data; 
    } else {
        echo "No file found.";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>