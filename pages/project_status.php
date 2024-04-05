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
    <link rel="stylesheet" href="/assets/css/details.css">
</head> 

<body>


<?php if(mysqli_num_rows($result) > 0): ?>
    <main>
        <div class="container">
            <h2>Project Status</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-info">
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
        </div>   
    </main>
    <?php include "../inc/footer.inc.php"; ?> 
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>

<div id="popup" class="form-popup">
    <div class="form-container">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Project Details</h2>
        <table class="table">
            <tr>
                <td><strong>Project:</strong></td>
                <td id="projectName"></td>
            </tr>
            <tr>
                <td><strong>Description:</strong></td>
                <td id="projectDescription"></td>
            </tr>
            <tr>
                <td><strong>Coins Offered:</strong></td>
                <td id="coinsOffered"></td>
            </tr>
            <tr>
                <td><strong>Expiry Date:</strong></td>
                <td id="expiryDate"></td>
            </tr>
            <tr>
                <td><strong>Rules of Engagement:</strong></td>
                <td><a id="roeLink" href="#" class="btn btn-primary">Download Rules of Engagement</a></td>
            </tr>
            <tr>
                <td><strong>Scope:</strong></td>
                <td><a id="scopeLink" href="#" class="btn btn-primary">Download Scope</a></td>
            </tr>
            <tr>
                <td><strong>Completion Date:</strong></td>
                <td id="completionDate"></td>
            </tr>
        </table>
    </div>
</div>

<script>
    function openPopup(name, description, coinsOffered, expiryDate, projectID, completionDate) {
        document.getElementById("projectName").innerHTML = name;
        document.getElementById("projectDescription").innerHTML = description;
        document.getElementById("coinsOffered").innerHTML = coinsOffered;
        document.getElementById("expiryDate").innerHTML = expiryDate;
        document.getElementById("completionDate").innerHTML = completionDate;

        var roeLink = document.getElementById("roeLink");
        roeLink.href = "../processes/projects/download.php?type=roe&id=" + projectID;

        var scopeLink = document.getElementById("scopeLink");
        scopeLink.href = "../processes/projects/download.php?type=scope&id=" + projectID;

        document.getElementById("popup").style.display = "block";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

</body> 

</html> 