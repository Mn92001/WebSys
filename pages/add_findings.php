<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Findings</title>
    <?php
    include "../inc/head.inc.php";
    ?>
</head>

<body>
    <?php

    session_start();
   
    include "../inc/navpentester.inc.php";

    // Display success message
    if (isset($_SESSION['success'])) {
        $successMsg = $_SESSION['success'];
        unset($_SESSION['success']); 

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . htmlspecialchars($successMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
    } 

    if (isset($_SESSION['PenReportID'])) {
        $penReportID = $_SESSION['PenReportID'];
        echo "PenReportID: " . htmlspecialchars($_SESSION['PenReportID']);
    } else {
        // Handle the case where penReportID is not set in the session.
        echo "PenReportID is not set or is null.";
    }
    ?>
     
     <main class="container">
        <h1>Add Findings</h1>

        <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

        <form action="../processes/report/process_add_findings.php" method="post">
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type="text" id="description" name="description" class="form-control" placeholder="Enter Project Description" pattern="^[a-zA-Z0-9_\s]{20,}$" 
                title="Description must be at least 20 characters long and can contain letters, numbers, and underscores." required>
            </div>
            <div class="mb-3">
             <label for="severityLevel" class="form-label">Severity Level</label>
                <select class="form-select" id="severityLevel" name="severityLevel" aria-label="Severity Level" required>
                    <option selected disabled value="">Please select severity level</option>
                    <option value="Information">Information</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Critical">Critical</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="owasp" class="form-label">OWASP</label>
                <input type="text" id="owasp" name="owasp" class="form-control" placeholder="Enter OWASP" pattern="^[a-zA-Z0-9_\s]{10,}$" 
                title="Must be at least 10 characters long and can contain letters, numbers, and underscores." required>
            </div>
            <div class="mb-3">
                <label for="cveDetail" class="form-label">CVE Details</label>
                <input type="text" id="cveDetail" name="cveDetail" class="form-control" placeholder="Enter CVEDetail" pattern="^[a-zA-Z0-9_\s]{10,}$" 
                title="Must be at least 10 characters long and can contain letters, numbers, and underscores." required>
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="history.back();">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>


    </main>   
    <?php include "../inc/footer.inc.php"; ?> 
</body> 

</html> 