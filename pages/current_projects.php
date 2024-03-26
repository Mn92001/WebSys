<!DOCTYPE html>
<html lang="en">

<head>
    <title>Current Projects</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
</head> 

<body>
    <?php
    session_start();
    
    include "../inc/navpentester.inc.php";
    include "../processes/current_projects/query.php";
    
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
        <main class="container mt-4">
            <h2>Current Projects</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Expiry Date</th>
                        <th>Client Approval Status</th>
                        <th>Report Approval Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ProjectName']); ?></td>
                            <td><?php echo htmlspecialchars($row['LockedInExpiryDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['ApprovalStatus']); ?></td>
                            <td><?php echo htmlspecialchars($row['ClientApprovalStatus']); ?></td>
                            <td>
                                <button class="btn btn-success">Lock In</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
        </main>

    <?php else: ?>
        <p>No locked in projects found. Please go to the <a href="projects.php">New Projects</a> page.</p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
 
</body> 

</html> 