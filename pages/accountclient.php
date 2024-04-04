<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Account</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include '../inc/db.php';?> 
    <?php include "../inc/navclient.inc.php";?> 
    <?php include "../processes/account_client/query.php";?>
    <?php include "../inc/clientcheck.inc.php";?>s
    <?php include "../inc/session.inc.php"; ?>
    <link rel="stylesheet" href="/assets/css/accountclient.css">
</head> 


<body>
    <?php if(mysqli_num_rows($result) > 0): ?>
        <main class="container">
            <h1>Account</h1>
            <!-- Header Fields -->
            <div class="table-responsive">
                <table>
                    <thead >
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
                            <td><input type="button" id= "btncoins" value="Topup Coins" onclick="showForm('coins'); opencoinsForm();"></td>
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
                        <tr>
                            <td><a href='authenticator_pair.php' class="btn btn-secondary btn-sm" role='button'>Enable Two Factor Authentication</a></td>
                        </tr>
                        </tr>
                        <?php endwhile; ?>
                    </thead>
                </table>
            </div>
            
            <div class="coinsform-popup" id="coinsFormPopup">
                <!-- Coins Top-up Form -->
                <form id="coinsForm" style="display:none;" action="../processes/account_client/update.php" method="post">
                    <input type="hidden" name="update_type" value="coins">
                    <h2>Top-up Coins</h2>
                    <div class="mb-3">
                        <label for="coins" class="form-label">Coins:</label>
                        <input required type="number" id="coins" name="coins" class="form-control" placeholder="Enter coins to top up" min="1">
                        <div class="invalid-feedback">
                            Please enter a valid number for coins.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="creditCard" class="form-label">Credit Card Number:</label>
                        <input required type="text" id="creditCard" name="creditCard" class="form-control" placeholder="Enter credit card number" pattern="\d{16}" title="Credit card number must be 16-digits">
                        <div class="invalid-feedback">
                            Please enter a 16-digit number for the credit card.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Expiry Date (MM/YY):</label>
                        <input required type="text" id="expiryDate" name="expiryDate" class="form-control" placeholder="Enter expiry date (MM/YY)" pattern="(0[1-9]|1[0-2])\/\d{2}" title="Expiry date must be in MM/YY format">
                        <div class="invalid-feedback">
                            Please enter expiry date in MM/YY format.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pin" class="form-label">3-digit PIN:</label>
                        <input required type="password" id="pin" name="pin" class="form-control" placeholder="Enter 3-digit PIN" pattern="[0-9]{3}" title="PIN must be a 3-digit number">
                        <div class="invalid-feedback">
                            Please enter a 3-digit PIN.
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
                    </div>
                </form>
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
            <form id="passwordForm" action="../processes/account_client/update.php" method="post">
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
            var coinsForm = document.getElementById('coinsForm');
            var btnemail = document.getElementById('btnemail');
            var btnnumber = document.getElementById('btnnumber');
            var btnpassword = document.getElementById('btnpassword');
            var btndelete = document.getElementById('btndelete');
            var btncoins = document.getElementById('btncoins');

            if (emailForm && numberForm && passwordForm && deleteForm && coinsForm) {
                emailForm.style.display = role === 'email' ? 'block' : 'none';
                numberForm.style.display = role === 'number' ? 'block' : 'none';
                passwordForm.style.display = role === 'password' ? 'block' : 'none';
                deleteForm.style.display = role === 'delete' ? 'block' : 'none';
                coinsForm.style.display = role === 'coins' ? 'block' : 'none';
            }

            
        }

        function openemailForm() {
            document.getElementById("emailFormPopup").style.display = "block";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
            document.getElementById("coinsFormPopup").style.display = "none";
        }

        function opennumberForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "block";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
            document.getElementById("coinsFormPopup").style.display = "none";
        }

        function openpasswordForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "block";
            document.getElementById("deleteFormPopup").style.display = "none";
            document.getElementById("coinsFormPopup").style.display = "none";
        }
        
        function opendeleteForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "block";
            document.getElementById("coinsFormPopup").style.display = "none";
        }

        function opencoinsForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
            document.getElementById("coinsFormPopup").style.display = "block";
        }

        // JavaScript function to close the popup form
        function closeForm() {
            document.getElementById("emailFormPopup").style.display = "none";
            document.getElementById("numberFormPopup").style.display = "none";
            document.getElementById("passwordFormPopup").style.display = "none";
            document.getElementById("deleteFormPopup").style.display = "none";
            document.getElementById("coinsFormPopup").style.display = "none";
        }
    </script>

    <?php include "../inc/footer.inc.php"; ?> 
</body> 
</html>
