<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report Submission</title>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/header.inc.php"; ?> 
    <?php include '../inc/db.php';?> 
</head> 

<body>
    <?php

    include "../inc/navpentester.inc.php";
    include "../processes/report/query.php";

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

    
    <main class="container mt-4">
        <h2>Report Submission</h2>
        
        <!-- Check for any currently locked records that have not yet been submitted-->
        <?php if ($hasLockInRecords): 

            // Check for the first row, if description is not null, display table. Else, no findings 
            $result->data_seek(0);
            $row = $row = $result->fetch_assoc();

            if($row['FindingsDescriptions'] != NULL): ?>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Description</th>
                            <th>Severity Level</th>
                            <th>OWASP</th>
                            <th>CVEDetails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $result->data_seek(0);
                        
                        while($row = $result->fetch_assoc()):
                            
                            $descriptions = explode(',', $row['FindingsDescriptions']);
                            $severityLevels = explode(',', $row['SeverityLevels']);
                            $owasps = explode(',', $row['OWASPs']);
                            $cveDetails = explode(',', $row['CVEDetails']);
                            
                            for($i = 0; $i < count($descriptions); $i++): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($descriptions[$i]); ?></td>
                                    <td><?php echo htmlspecialchars($severityLevels[$i]); ?></td>
                                    <td><?php echo htmlspecialchars($owasps[$i]); ?></td>
                                    <td><?php echo htmlspecialchars($cveDetails[$i]); ?></td>
                                </tr>
                                
                            <?php endfor;?>                          
                        <?php endwhile; ?>                                     
                    </tbody>                  
                </table>

                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="add_findings.php" class="btn btn-primary me-md-2" type="button">Add Findings</a>
                </div>

                <form id="penReportForm" action="../processes/report/submit.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="reportPdf" class="form-label">Pentester Report (PDF):</label>
                        <input type="file" id="reportPdf" name="reportPdf" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                </form>

            <?php else: ?>
                <hr>
                <p>No findings.</p>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="add_findings.php" class="btn btn-primary me-md-2" type="button">Add Findings</a>
                </div> 

                <hr>
            <?php endif; ?>

        <?php else: ?>
        <p>No current locked in record found. Please go to the <a href="projects.php">New Projects</a> page.</p>
    <?php endif; ?>
    </main>


    <?php include "../inc/footer.inc.php"; ?> 

</body> 

</html> 