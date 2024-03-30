<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Projects</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 

    <style>
        /* Popup form hidden by default */
        .form-popup {
            display: none;
        }
    </style>

</head> 

<body>
<?php
session_start();

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

include '../inc/db.php';
include "../inc/navpentester.inc.php";
include "../processes/projects/query.php";

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
        <h2>New projects</h2>
        <table class="table">
            <thead>
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
        
    </main>
<?php else: ?>
    <p>No projects found.</p>
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