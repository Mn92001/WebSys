<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pentester Projects</title>
    <?php include "../inc/pentestercheck.inc.php";?>
    <?php include "../inc/head.inc.php"; ?>
    <?php include '../inc/db.php';?> 
    <?php include "../inc/navpentester.inc.php";?>
    <?php include "../inc/session.inc.php";?>
    <link rel="stylesheet" href="/assets/css/projects.css">
    <link rel="stylesheet" href="/assets/css/details.css">
</head> 

<?php
// Check if the user role is not set or is not equal to "user"
    $userID = $_SESSION['user_id'];
    $queryPentester = "SELECT NoActiveLockedIn FROM Pentester WHERE UserID = ?";
    $pentesterLockedIn = 0;

    // Statement for queryPentester to get the pentesterID
    if ($stmt = $conn->prepare($queryPentester)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pentesterLockedIn = $row['NoActiveLockedIn']; 
        } 

        $stmt->close();
    } 

?>

<?php include "../processes/projects/query.php";?>


<body> 
<?php if(mysqli_num_rows($result) > 0): ?>
    <main>
        <div class="container mt-4">
        <h2>New projects</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Expiry Date</th>
                            <th>Coins Offered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['ProjectName']); ?></td>
                                <td><?php echo htmlspecialchars($row['ProjectExpiryDate']); ?></td>
                                <td><?php echo htmlspecialchars($row['CoinsOffered']); ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="openPopup('<?php echo htmlspecialchars($row['ProjectName']); ?>', '<?php echo htmlspecialchars($row['ProjectDescription']); ?>', '<?php echo htmlspecialchars($row['CoinsOffered']); ?>', '<?php echo htmlspecialchars($row['ProjectExpiryDate']); ?>', '<?php echo htmlspecialchars($row['ProjectID']); ?>', '<?php echo htmlspecialchars($row['DateOfCompletion']); ?>')">View Details</button>
                                    <?php
                                        if ($pentesterLockedIn != 0) {
                                            // There is an active locked-in project, hide lock in button
                                            echo '<p>A project has already been locked in</p>';
                                        } else {
                                            // No active locked-in projects, show lock in button
                                            echo '<form action="../processes/projects/lockin.php" method="post">';
                                            echo '<input type="hidden" name="project_id" value="' . htmlspecialchars($row['ProjectID']) . '">'; // Hidden input field to send project ID
                                            echo '<input type="hidden" name="project_expiry_date" value="' . htmlspecialchars($row['ProjectExpiryDate']) . '">'; // Hidden input field to send project expiry date
                                            echo '<button type="submit" class="btn btn-primary">Lock In</button>';
                                            echo '</form>';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>  
    </main>
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

<?php include "../inc/footer.inc.php"; ?> 
 

</html> 