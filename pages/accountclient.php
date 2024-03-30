<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Projects</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
</head> 

<body>
    <?php
    session_start();

    $userID = $_SESSION['user_id'];

    include '../inc/db.php';
    include "../inc/navclient.inc.php";
    include "../processes/account_client/query.php";

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
    ?>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <main class="container">
            <!-- Header Fields -->
            <div class="table">
                <table>
                    <thead>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th>Name:</th>
                            <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td><?php echo htmlspecialchars($row['Role']); ?></td>
                        </tr>
                        <tr>
                            <th>Coins:</th>
                            <td><?php echo htmlspecialchars($row['TotalCoins']); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Total Projects:</th>
                            <td><?php echo htmlspecialchars($row['Projects']); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Username:</th>
                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><input type="button" id="btnemail" value="Change Email" onclick="showForm('email'); openemailForm();"> </td>
                            
                             
                        </tr>
                        <tr>
                            <th>Phone Number:</th>
                            <td><?php echo htmlspecialchars($row['PhoneNumber']); ?></td>
                            <td><input type="button" id= "btnnumber" value="Change Number" onclick="showForm('number'); opennumberForm();"></td>
                        </tr>
                        <tr>
                            <td><input type="button" id= "btnpassword" value="Change Password" onclick="showForm('password'); openpasswordForm();"></td>
                            <td><input type="button" id= "btndelete" value="Delete Account" onclick="showForm('delete'); opendeleteForm();"></td>
                        </tr>
                        </tr>
                        <?php endwhile; ?>
                    </thead>
                </table>
            </div>
            
            <div class="emailform-popup" id="emailFormPopup">
            <!-- The email Registration Form -->
            <form id="emailForm" style="display:none;" action="../processes/account_client/update.php" method="post">
                <input type="hidden" name="update_type" value="email">
                <h2>Change Email</h2>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input required type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email address">
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
                </div>
            </form>
            </div>

        <div class="numberform-popup" id="numberFormPopup">
            <!-- number Registration Form -->
            <form id="numberForm" style="display:none;" action="../processes/account_client/update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_type" value="number">
                <h2>Change Number</h2>
                
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Phone Number:</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Enter phone number" pattern="^\+?[0-9]+$"
                    title="Phone number must contain only numbers and can start with a + for international numbers.">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
                </div>
            </form>
        </div>

        <div class="passwordform-popup" id="passwordFormPopup">
            <!-- The password Registration Form -->
            <form id="passwordForm" style="display:none;" action="../processes/account_client/update.php" method="post">
                <input type="hidden" name="update_type" value="password">
                <h2>Change Password</h2>
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
                    <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
                </div>
            </form>
            </div>

            <div class="deleteform-popup" id="deleteFormPopup">
            <!-- Delete Account Form -->
            <form id="deleteForm" style="display:none;" action="../processes/account_client/update.php" method="post">
            <input type="hidden" name="update_type" value="delete">
                <h2>Delete Account Confirmation</h2>
                <p>Are you sure you want to delete your account?</p>
                <div class="mb-3">
                    <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                    <button type="button" class="btn btn-primary" onclick="closeForm()">Cancel</button>
                </div>
            </form>
            </div>
            

        </main>
    <?php else: ?>
        <p>No data found.</p>
    <?php endif; ?>



    <!-- Script to handle popup functionality -->
    <script>
        function showForm(role) {
            // Use the correct ID for the email form
            var emailForm = document.getElementById('emailForm');
            var numberForm = document.getElementById('numberForm');
            var passwordForm = document.getElementById('passwordForm');
            var deleteForm = document.getElementById('deleteForm');
            var btnemail = document.getElementById('btnemail');
            var btnnumber = document.getElementById('btnnumber');
            var btnpassword = document.getElementById('btnpassword');
            var btndelete = document.getElementById('btndelete');

            if (emailForm && numberForm && passwordForm && deleteForm) {
                emailForm.style.display = role === 'email' ? 'block' : 'none';
                numberForm.style.display = role === 'number' ? 'block' : 'none';
                passwordForm.style.display = role === 'password' ? 'block' : 'none';
                deleteForm.style.display = role === 'delete' ? 'block' : 'none';
            }

            
        }

        function openemailForm() {
            document.getElementById("emailFormPopup").style.display = "block";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
        }

        function opennumberForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "block";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
        }

        function openpasswordForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "block";
            document.getElementById("deleteFormPopup").style.display = "none";
        }
        
        function opendeleteForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "block";
        }

        // JavaScript function to close the popup form
        function closeForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
        }
    </script>

    <?php include "../inc/footer.inc.php"; ?> 
</body> 
</html>
