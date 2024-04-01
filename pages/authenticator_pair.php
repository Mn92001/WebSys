<!DOCTYPE html>
<html lang="en">

<head>
    <title>Google Authenticator</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
</head> 

<body>
    <?php
    
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect them to login page
        header('Location: login.php');
        exit;

    } else {
        // Retrieve user information from session variables
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];
    }

    if ($role === 'Client') {
        // Client navigation
        include "../inc/navclient.inc.php";
    } elseif ($role === 'Pentester') {
        // Pentester navigation
        include "../inc/navpentester.inc.php";
    } elseif ($role === 'Admin') {
        // Admin navigation
        include "../inc/navadmin.inc.php";
    } 

    // Retrieve and display success message
    if (isset($_SESSION['success'])) {
        $successMsg = $_SESSION['success'];
        unset($_SESSION['success']); 

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . htmlspecialchars($successMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
    } 

    // Retrieve and display error messages

    if (isset($_SESSION['error'])) {
        $errorMsg = $_SESSION['error'];
        unset($_SESSION['error']); 
        
        echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars($errorMsg) . "</div>";
    }

    function base32_encode($data) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $padChar = '=';
        $padType = STR_PAD_RIGHT;
    
        $l = strlen($data);
        $n = $l << 3;
        $m = $n % 5;
        $padLength = ($m ?: 0) ? 5 - $m : 0;
    
        $data .= str_repeat("\0", $padLength);
        $c = strlen($data);
        $result = '';
    
        for ($i = 0; $i < $c; $i += 5) {
            $chunk = substr($data, $i, 5);
            $binaryPattern = '';
    
            foreach (str_split($chunk) as $char) {
                $binaryPattern .= sprintf('%08b', ord($char));
            }
    
            $binaryPattern = str_pad($binaryPattern, 40, '0', $padType);
    
            for ($j = 0; $j < 40; $j += 5) {
                $binChunk = substr($binaryPattern, $j, 5);
                $intIndex = bindec($binChunk);
                $result .= $alphabet[$intIndex] ?? $padChar;
            }
        }
    
        return $result;
    }
    
    $randomBytes = random_bytes(10); 
    $secret = base32_encode($randomBytes); 

    $appName = 'FortifyTech';
    $userName = $_SESSION['username'];
    $_SESSION['google_auth_secret'] = $secret;

    $cURLConnection = curl_init("https://www.authenticatorApi.com/pair.aspx?AppName=" . urlencode($appName) . "&AppInfo=" . urlencode($userName) . "&SecretCode=" . $secret);

    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $apiResponse = curl_exec($cURLConnection);

    curl_close($cURLConnection);       
    ?>

    <main class="container mt-4">
        <h2>Google Authenticator Setup</h2>
        <p>Please scan the QR code below with your Google Authenticator app.</p>
        <!-- Display QR code for scanning -->
        <?php echo $apiResponse; ?>

        <h3>Verify OTP</h3>
        <p>Enter the verification code generated by your Google Authenticator app.</p>
        <form method="post" action="../processes/verify_otp.php">


        <input type="text" class="form-control" min="4" name="pin" max="6" required/>
        <br><br>
        <button name="submit-pin" type="submit" class="btn btn-primary">Enter</button>


        </form>

    </main>

    <?php include "../inc/footer.inc.php"; ?> 


</body> 

</html> 