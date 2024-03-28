<?php 
session_start(); 

// Check for any error messages
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
                        <form> 
                            <h2>Login</h2>
                            <input type="text" placeholder="Username">
                            <input type="password" placeholder="Password">
                            <input type="submit" value="Login">
                            <p class="register">don't have an account? <a href="register.php">Register</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>       
    </main>
    <?php include "../inc/footer.inc.php"; ?>
</body>

</html>
