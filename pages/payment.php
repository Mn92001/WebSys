<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transaction</title>
    <?php
    include "../inc/head.inc.php";
    include "../inc/header.inc.php";
    ?>
</head>

<body>
    <?php

    session_start();
   
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect them to login page
        header('Location: login.php');
        exit;

    } else {
        // Retrieve user information from session variables
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];
    }

    if ($role === 'Client') {
        // Client navigation
        include "../inc/navclient.inc.php";
    } elseif ($role === 'Pentester' && $status === 'Approved') {
        // Pentester navigation
        include "../inc/navpentester.inc.php";
    } elseif ($role === 'Admin') {
        // Admin navigation
        include "../inc/navadmin.inc.php";
    } 

    // Retrieve and display success messages
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

    // Retrieve payment details
    if (isset($_SESSION['details'])) {
        $details = $_SESSION['details'];

        // $_SESSION['receiverid'] = $details['ReceiverID'];
        $_SESSION['receiverRole'] = $details['ReceiverRole'];
        $_SESSION['projectid'] = $details['ProjectID'];
        unset($_SESSION['details']);
    }
    ?>
     
     <main class="container">
        <h1>Transaction</h1>

        <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

        <form action="../processes/process_payment.php" method="post">
            <div class="mb-3">
                <label for="sender" class="form-label">Sender:</label>
                <input disabled type="text" id="sender" name="sender" class="form-control" placeholder="<?php echo htmlspecialchars($details['SenderUserName']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="receiver" class="form-label">Receiver:</label>
                <input disabled type="text" id="receiver" name="receiver" class="form-control" placeholder="<?php echo htmlspecialchars($details['ReceiverUserName']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="receiver" class="form-label">Payable Coins:</label>
                <input disabled type="text" id="receiver" name="receiver" class="form-control" placeholder="<?php echo htmlspecialchars($details['CoinsOffered']); ?>" required>
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="history.back();">Cancel</button>
                <button type="submit" class="btn btn-primary">Transfer</button>
            </div>
        </form>


    </main>   
    <?php include "../inc/footer.inc.php"; ?> 
</body> 

</html> 