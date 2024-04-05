<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/navpentester.inc.php";?>
    <?php include '../inc/db.php';?> 
    <?php include "../inc/pentestercheck.inc.php";?>
    <?php include "../inc/session.inc.php"; ?>
    <?php include "../processes/current_projects/query.php"; ?>
    <?php include "../processes/current_projects/details.php"; ?>
    <link rel="stylesheet" href="/assets/css/currentprojects.css">
    <link rel="stylesheet" href="/assets/css/details.css">
</head> 

<body>
 
    <?php if(mysqli_num_rows($result) > 0): ?>
        <main>
        <section class="container container-fluid">
            <div class="container mt-4">
            <h2>My Projects</h2>
            <table class="table table-bordered table-hover table-responsive-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Expiry Date</th>
                        <th>Report Submission Status</th>
                        <th>Report Approval Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        
                        <tr class="<?php echo $row['ClientApprovalStatus'] == 'Approved' ? 'table-secondary' : ''; ?>">
                            <td><?php echo htmlspecialchars($row['ProjectName']); ?></td>
                            <td><?php echo htmlspecialchars($row['LockedInExpiryDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['ReportStatus']); ?></td>
                            <td>
                                <?php echo $row['ClientApprovalStatus'] != null ? htmlspecialchars($row['ClientApprovalStatus']) : '-'; ?>
                            </td>
                            <td>
                                <button class="btn btn-primary" onclick="openPopup(
                                    '<?php echo htmlspecialchars($row['ProjectName']); ?>', 
                                    '<?php echo htmlspecialchars($row['ProjectDescription']); ?>', 
                                    '<?php echo htmlspecialchars($row['CoinsOffered']); ?>', 
                                    '<?php echo htmlspecialchars($row['ProjectExpiryDate']); ?>', 
                                    '<?php echo htmlspecialchars($row['ProjectID']); ?>', 
                                    '<?php echo htmlspecialchars($row['DateOfCompletion']); ?>')">View Details
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </section> 
        </main>

    <?php else: ?>
        <p>No locked in projects found. Please go to the <a href="projects.php">New Projects</a> page.</p>
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
            <tr >
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

<?php include "../inc/footer.inc.php"; ?> 
</html> 