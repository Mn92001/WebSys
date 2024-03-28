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
    <link rel="stylesheet" href="/assets/css/register.css">
</head>

<body>
    <?php
    include "../inc/nav.inc.php";
    ?>
    <!-- <main class="container"> -->
    <main> 
        <!-- <h1>Registration</h1>
        <p>
            For existing client/pentester, please go to the
            <a href="../pages/login.php">Sign In page</a>.
        </p> -->

        <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

         <!-- Role Selection Buttons -->
        <!-- <div class="mb-3">
            <button id="btnClient" class="btn btn-secondary" onclick="showForm('client')">Register as Client</button>
            <button id="btnPentester" class="btn btn-secondary" onclick="showForm('pentester')">Register as Pentester</button>
        </div> -->
        <section>
            <div class="container">
                <div class="client-registrationBx">
                    <div class="imgBx"><img src="../assets/images/registration.png"></div>
                    <div class="client-formBx">
                        <form> 
                            <h2>Registration</h2>
                            <input type="button" id="btnClient" value="Register as Client" onclick="showForm('client')"> 
                            <input type="button" id= "btnPentester" value="Register as PenTester" onclick="showForm('pentester')"> 
                            <p class="register">for existing client/pentester, please go to the login page <a href="../pages/login.php">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </section> 

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

<<script>
    function showForm(role) {
        // Use the correct ID for the client form
        var clientForm = document.getElementById('clientForm');
        var pentesterForm = document.getElementById('pentesterForm');
        var btnClient = document.getElementById('btnClient');
        var btnPentester = document.getElementById('btnPentester');

        if (clientForm && pentesterForm) {
            clientForm.style.display = role === 'client' ? 'block' : 'none';
            pentesterForm.style.display = role === 'pentester' ? 'block' : 'none';
        }

        // Handle button color change
        if (btnClient && btnPentester) {
            if (role === 'client') {
                btnClient.classList.add('btn-primary');
                btnClient.classList.remove('btn-secondary');
                
                btnPentester.classList.add('btn-secondary');
                btnPentester.classList.remove('btn-primary');
            } else if (role === 'pentester') {
                btnPentester.classList.add('btn-primary');
                btnPentester.classList.remove('btn-secondary');
                
                btnClient.classList.add('btn-secondary');
                btnClient.classList.remove('btn-primary');
            }
        }
    }
</script>



    

</body>

</html>