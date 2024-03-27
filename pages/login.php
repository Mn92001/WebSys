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
    <style>
        /* Add any custom styles for login page here */
    </style>
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
        <!-- <div class="container">
            <div class="user signinBx">
                <div class="imgBx"><img src="img1.jpg"></div> -->
        
        <h1>Login</h1>
        <p>Existing members log in here. For new members, please go to the <a href="register.php">Member Registration page</a>.</p>
        <form action="../processes/process_login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input required maxlength="45" required type="username" id="username" name="username" class="form-control" placeholder="Enter username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input required type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                 pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" >
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </main>
    <?php include "../inc/footer.inc.php"; ?>
</body>

</html>
