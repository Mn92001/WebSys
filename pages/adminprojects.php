<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Projects</title>
    <?php include "../inc/admincheck.inc.php";?>s
    <?php include "../inc/head.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
    <?php include "../inc/session.inc.php"; ?>
    <?php include "../inc/navadmin.inc.php"; ?>
    <?php include "../processes/admin/projectsquery.php"; ?>
    <link rel="stylesheet" href="../assets/css/adminprojects.css">
</head> 

<body>
    <?php
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
            <div class="table-responsive">
                <table class="table table-bordered border-info table-hover">
                <thead>
                    <tr class="table-info">
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
                </div> 
        </main>

    <?php else: ?>
        <p>No projects found. </p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
 

</body> 

</html> 