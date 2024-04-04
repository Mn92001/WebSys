<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project Status</title>
    <?php include "../inc/clientcheck.inc.php";?>
    <?php include "../inc/head.inc.php"; ?>
    <?php include '../inc/db.php';?> 
    <?php include "../inc/navclient.inc.php";?> 
    <?php include "../inc/session.inc.php"; ?>
    <?php include "../processes/project_status/query.php";?> 
    <link rel="stylesheet" href="/assets/css/project_status.css">
</head> 

<body>


<?php if(mysqli_num_rows($result) > 0): ?>
    <main>
        <section class="container container-fluid">
            <div class="container">
                <h2>Project Status</h2>

                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</div></th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Report</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['ProjectName']); ?></td>
                                <td><?php echo htmlspecialchars($row['ProjectExpiryDate']); ?></td>
                                <td><?php echo htmlspecialchars($row['ProjectStatus']); ?></td>
                                <td>
                                    <?php if ($row['ClientApprovalStatus'] == 'Pending'): ?>
                                        <a href="../processes/projects/download.php?type=briefReport&id=<?php echo $row['ProjectID']; ?>" class="btn btn-link btn-sm">Download Brief Report</a>
                                    <?php elseif($row['ClientApprovalStatus'] == 'Approved'): ?>
                                        <a href="../processes/projects/download.php?type=fullReport&id=<?php echo $row['ProjectID']; ?>" class="btn btn-link link-success btn-sm">Download Full Report</a>
                                    <?php else:?>
                                        <p>-</p>   
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary" id="viewDetailsBtn" onclick="openPopup('<?php echo htmlspecialchars($row['ProjectName']); ?>', '<?php echo htmlspecialchars($row['ProjectDescription']); ?>', '<?php echo htmlspecialchars($row['CoinsOffered']); ?>', '<?php echo htmlspecialchars($row['ProjectExpiryDate']); ?>', '<?php echo htmlspecialchars($row['ProjectID']); ?>', '<?php echo htmlspecialchars($row['DateOfCompletion']); ?>')">View Details</button>
                                    <br>                
                                    <?php if ($row['ClientApprovalStatus'] == 'Pending'): ?>
                                        <form action="../processes/process_payment_detail.php" method="post">
                                            <input type="hidden" name="projectID" value="<?php echo $row['ProjectID']; ?>">
                                            <input type="hidden" name="receiver" value="Pentester">
                                            <button class="btn btn-success" id= "approveBtn" type="submit">Approve</a>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>   
    </main>
    <?php include "../inc/footer.inc.php"; ?> 
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>


    
 
    <script>
        function openPopup(name, description, coinsOffered, expiryDate, projectID, completionDate) {
            // Create popup content
            var popupContent = "<p><strong>Project:</strong> " + name + "</p>" +
                                "<p><strong>Description:</strong> " + description + "</p>" +
                               "<p><strong>Coins Offered:</strong> " + coinsOffered + "</p>" +
                               "<p><strong>Expiry Date:</strong> " + expiryDate + "</p>" +
                               "<p><strong>Download Resume:</strong> <a href='../processes/projects/download.php?type=roe&id=" + projectID + "' class='btn btn-link btn-sm'>Download Rules of Engagemnt</a></p>" +
                                "<p><strong>Download Certification:</strong> <a href='../processes/projects/download.php?type=scope&id=" + projectID + "' class='btn btn-link btn-sm'>Download Scope</a></p>" +
                               "<p><strong>Completion Date:</strong> " + completionDate + "</p>" 

            // Create popup window
            var popupWindow = window.open("", "_blank", "width=400,height=400");
            
            // Write content to popup window
            popupWindow.document.write(popupContent);
        }

    </script>

</body> 

</html> 