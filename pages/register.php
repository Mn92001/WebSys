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
    <title>Registration</title>
    <?php
    include "../inc/head.inc.php";
    ?>
</head>

<body>
    <?php
    include "../inc/nav.inc.php";
    ?>
    <main class="container">
        <h1>Registration</h1>
        <p>
            For existing client/pentester, please go to the
            <a href="../pages/login.php">Sign In page</a>.
        </p>

        <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

         <!-- Role Selection Buttons -->
        <div class="mb-3">
            <button id="btnClient" class="btn btn-secondary" onclick="showForm('client')">Register as Client</button>
            <button id="btnPentester" class="btn btn-secondary" onclick="showForm('pentester')">Register as Pentester</button>
        </div>

        <!-- Client Registration Form -->
        <form id="clientForm" style="display:none;" action="../processes/register_client.php" method="post">
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

         <!-- Pentester Registration Form -->
        <form id="pentesterForm" style="display:none;" action="../processes/register_pentester.php" method="post" enctype="multipart/form-data">
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
                <label for="resumePdf" class="form-label">Resume (PDF):</label>
                <input type="file" id="resumePdf" name="resumePdf" class="form-control" accept="application/pdf">
            </div>
            <div class="mb-3">
                <label for="certPdf" class="form-label">Certification (PDF):</label>
                <input type="file" id="certPdf" name="certPdf" class="form-control" accept="application/pdf">
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

<script>
    function showForm(role) {
    document.getElementById('clientForm').style.display = role === 'client' ? 'block' : 'none';
    document.getElementById('pentesterForm').style.display = role === 'pentester' ? 'block' : 'none';

    // Handle button color change
    if (role === 'client') {
        
        document.getElementById('btnClient').classList.remove('btn-secondary');
        document.getElementById('btnClient').classList.add('btn-primary');
        
        document.getElementById('btnPentester').classList.remove('btn-primary');
        document.getElementById('btnPentester').classList.add('btn-secondary');
    } else if (role === 'pentester') {
        
        document.getElementById('btnPentester').classList.remove('btn-secondary');
        document.getElementById('btnPentester').classList.add('btn-primary');
        
        document.getElementById('btnClient').classList.remove('btn-primary');
        document.getElementById('btnClient').classList.add('btn-secondary');
    }
}
</script>


    

</body>

</html>