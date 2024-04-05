<!DOCTYPE html>
<html lang="en">


<title>Login</title>
<?php include "../inc/head.inc.php"; ?>
<?php include "../inc/nav.inc.php"; ?>
<link rel="stylesheet" href="/assets/css/login.css">
    



<?php
session_start(); 

// Display success message
if (isset($_SESSION['success'])) {
    $successMsg = $_SESSION['success'];
    unset($_SESSION['success']); 

    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='margin-top: 45px; margin-bottom: 0;'>" . htmlspecialchars($successMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
} 

// Retrieve and display error messages
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); 
    
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='margin-top: 45px; margin-bottom: 0;'>" . htmlspecialchars($errorMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
}
?>
<body>
    <main>
        <section>
            <div class="container">
                <div class="user loginBx">
                    <div class="imgBx"><img src="../assets/images/login.png"></div>
                    <div class="formBx">
                        <form action="../processes/process_login.php" method="post"> 
                            <h2>Login</h2>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input required maxlength="45" required type="username" id="username" name="username" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input required type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" >
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <div class="mb-3">
                                <p class="register">Don't have an account? <a href="register.php">Register</a></p>
                                <p class="forgotPassword"> Forgotten your password? <a href="#">Forget Password</a><p> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>       
    </main>
    <?php include "../inc/footer.inc.php"; ?>
</body>

</html>
