<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pentester - Login</title>
    <?php include "inc/head.inc.php"; ?>
    <style>
        /* Add any custom styles for login page here */
    </style>
</head>

<body>
    <?php include "inc/nav.inc.php"; ?>
    <main class="container">
        <h1>Login</h1>
        <p>Existing members log in here. For new members, please go to the <a href="register.php">Member Registration page</a>.</p>
        <form action="process_login.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input required type="email" id="email" name="email" class="form-control" placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input required type="password" id="password" name="password" class="form-control" placeholder="Enter password">
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
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>
