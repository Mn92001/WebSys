<?php
session_start(); 

$errorMsg = "";
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Registration</title>
    <?php
    include "../inc/head.inc.php";
    ?>
</head>

<body>
    <?php
    include "../inc/nav.inc.php";
    ?>
    <main class="container">
        <h1>Client Registration</h1>
        <p>
            For existing client, please go to the
            <a href="#">Sign In page</a>.
        </p>

        <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

        <form action="../processes/register_client.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" pattern="^[a-zA-Z0-9_]{5,}$" 
                title="Username must be at least 5 characters long and can contain letters, numbers, and underscores." required>
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter full name" pattern="^[a-zA-Z\s]+$" 
                title="Full name must contain only letters and spaces." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input required type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email address">
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Enter phone number" pattern="^\+?[0-9]+$"
                title="Phone number must contain only numbers and can start with a + for international numbers.">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input required type="password" id="pwd" name="pwd" class="form-control" placeholder="Enter password"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" 
                title="Password must contain at least 8 characters, including at least one number, one uppercase letter, one lowercase letter, and one special character.">
            </div>
            <div class="mb-3">
                <label for="pwd_confirm" class="form-label">Confirm Password:</label>
                <input required type="password" id="pwd_confirm" name="pwd_confirm" class="form-control"
                    placeholder="Confirm password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" 
                    title="Password must contain at least 8 characters, including at least one number, one uppercase letter, one lowercase letter, and one special character.">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </main>
    <?php
    include "../inc/footer.inc.php";
    ?>
</body>

</html>