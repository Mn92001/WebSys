<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Projects</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
</head> 

<body>
    <?php

    include "../inc/navadmin.inc.php";
    include "../processes/process_adminprojects.php";


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

    function getProjectStatus($reportStatus, $clientApprovalStatus) {
        if ($reportStatus == 'Pending') {
            return 'In Progress';
        } elseif ($reportStatus == 'Submitted' && $clientApprovalStatus == 'Pending') {
            return 'Awaiting Client Approval';
        } elseif ($reportStatus == 'Submitted' && $clientApprovalStatus == 'Approved') {
            return 'Completed';
        } else {
            return '-';
        }
    }

    ?>
 

    <?php if(mysqli_num_rows($result) > 0): ?>
        <main class="container mt-4">
            <h2>Ongoing Projects</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Pentester</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ProjectName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Client']); ?></td>
                            <td><?php echo htmlspecialchars($row['Pentester']); ?></td>
                            <td><?php echo getProjectStatus($row['ReportStatus'], $row['ClientApprovalStatus']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
        </main>

    <?php else: ?>
        <p>No projects found. </p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
 

</body> 

</html> 