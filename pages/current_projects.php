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
                        <th>Report Submission Status</th>
                        <th>Report Approval Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php include "../processes/current_projects/details.php"; ?>
                        <tr>
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
            
        </main>

    <?php else: ?>
        <p>No locked in projects found. Please go to the <a href="projects.php">New Projects</a> page.</p>
    <?php endif; ?>

    <?php include "../inc/footer.inc.php"; ?> 
 
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