<?php
    session_start();

    include '../inc/db.php'; 

    $pin = $_POST['pin'];
    $pin = (int)$pin;
    $secret_code = $_SESSION['google_auth_secret'];
    $username = $_SESSION['username'];

    unset($_SESSION['google_auth_secret']); 

    $errorMsg = $successMsg = "";

    $cURLConnection = curl_init('https://www.authenticatorApi.com/Validate.aspx?Pin='.$pin.'&SecretCode='.$secret_code);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $apiRes = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $jsonArrayResponse = json_decode($apiRes);

    if ($apiRes == 'True') {
        $query = "UPDATE UserMaster SET TwoFactorEnabled = 1, authCode = ? WHERE Username = ?";

        if($stmt = $conn->prepare($query)){

            $stmt->bind_param("ss", $secret_code, $username);

            if($stmt->execute()){

                $_SESSION['success'] = "Google Authenticator 2FA is set up successfully.";

                header("Location: ../index.php");
                exit;

            } else {
                echo "Error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    }
    else {

        $_SESSION['error'] = "Google Authenticator 2FA set up unsuccessful.";

        header("Location: ../index.php");
        exit;
    }
?>
