<?php 
session_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$errorMsg = "";
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php include "../inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/assets/css/login.css">
    
</head>

<body>
    <?php include "../inc/nav.inc.php"; ?>

    <!-- Display error messages -->
    <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($errorMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <main>
        <section>
            <div class="container">
                <div class="user loginBx">
                    <div class="imgBx"><img src="../assets/images/login.png"></div>
                    <div class="formBx">
                        <form action="../processes/process_login_2fa.php" method="post">
                            <label for="otp">Enter the OTP from your authenticator app:</label>
                            <input type="text" id="otp" name="otp" required>
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>       
    </main>
    <?php include "../inc/footer.inc.php"; ?>
</body>

</html>
