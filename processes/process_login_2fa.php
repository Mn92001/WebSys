<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../inc/db.php';
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $otp = $_POST['otp'];

    $authCode = getAuthCode($conn, $username);

    $cURLConnection = curl_init('https://www.authenticatorApi.com/Validate.aspx?Pin='.$otp.'&SecretCode='.$authCode);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $apiRes = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $jsonArrayResponse = json_decode($apiRes);

    if ($apiRes == 'True') {
        if($role == "Pentester"){
            $_SESSION['approved'] = "Approved";
        }

        $_SESSION['success'] = "Login successful.";
        header('Location: ../index.php');
        exit;

    }
    else {

        // 2FA failed
        unset($_SESSION['username']); 
        unset($_SESSION['user_id']); 
        unset($_SESSION['role']); 
        $_SESSION['error'] = 'Invalid OTP.';
        header('Location: ../pages/login.php');
        exit;
    }


    function getAuthCode($conn, $username){
        $query = "SELECT authCode FROM UserMaster WHERE Username = ?";

        if($stmt = $conn->prepare($query)){

            $stmt->bind_param("s", $username);

            if($stmt->execute()){

                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $authCode = $row['authCode'];

            } else {
                echo "Error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();

        return $authCode;
    }
?>