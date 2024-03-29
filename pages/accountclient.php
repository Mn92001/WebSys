<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Projects</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 

    <style>
        /* Adjust layout to display data fields top-down */
        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-top: 20px;
        }

        .container .table {
            width: 100%; /* Adjust width of tables */
        }

        .container .data-fields table {
            margin-top: 10px; /* Add margin between header fields and data fields */
        }
    </style>

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
                        </tr>
                        <tr>
                            <th>Total Projects:</th>
                            <td><?php echo htmlspecialchars($row['Projects']); ?></td>
                        </tr>
                        <tr>
                            <th>Username:</th>
                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number:</th>
                            <td><?php echo htmlspecialchars($row['PhoneNumber']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </thead>
                </table>
            </div>
        </main>
    <?php else: ?>
        <p>No data found.</p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
</body> 

</html>
