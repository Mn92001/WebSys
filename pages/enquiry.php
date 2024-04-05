<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Projects</title>
    <?php include "../inc/admincheck.inc.php";?>s
    <?php include "../inc/head.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
    <?php include "../inc/session.inc.php"; ?>
    <?php include "../inc/navadmin.inc.php"; ?>
    <?php include "../processes/admin/enquiryquery.php"; ?>
    <link rel="stylesheet" href="../assets/css/enquiry.css">
</head> 

<body>

 

    <?php if(mysqli_num_rows($result) > 0): ?>
        <main>
            <div class="container mt-4">
                <h2>Enquiries</h2>
                <div class="table-responsive">
                <table class="table table-bordered border-info table-hover">
                    <thead>
                        <tr class="table-info">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                <td><?php echo htmlspecialchars($row['Message']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </main>

    <?php else: ?>
        <p>No projects found. </p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
 

</body> 

</html> 