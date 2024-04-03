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
                            <th></th>
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
                            
                            $findingids = explode(',', $row['FindingIDs']);
                            $descriptions = explode(',', $row['FindingsDescriptions']);
                            $severityLevels = explode(',', $row['SeverityLevels']);
                            $owasps = explode(',', $row['OWASPs']);
                            $cveDetails = explode(',', $row['CVEDetails']);
                            
                            for($i = 0; $i < count($descriptions); $i++): ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="findingIDs[]"value="<?php echo htmlspecialchars($findingids[$i]); ?>">             
                                    </td>   
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
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-findingid="findingIDs[]">Delete</button>
                </div>

                <form id="penReportForm" action="../processes/report/submit.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="reportPdf" class="form-label">Pentester Report (PDF):</label>
                        <input type="file" id="reportPdf" name="reportPdf" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="briefReportPdf" class="form-label">Brief Pentester Report (PDF):</label>
                        <input type="file" id="briefReportPdf" name="briefReportPdf" class="form-control" accept="application/pdf" required>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this finding?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form action="../processes/report/delete.php" method="post">
                <input type="hidden" name="findingID" id="findingIDs" value="">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        </div>
    </div>
    </div>



    </main>


    <?php include "../inc/footer.inc.php"; ?> 

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = deleteModal.querySelector('form');

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const existingHiddenInputs = deleteForm.querySelectorAll('input[type="hidden"][name="findingIDs[]"]');
                existingHiddenInputs.forEach(input => input.remove());

                const checkedCheckboxes = document.querySelectorAll('.form-check-input:checked');
                
                checkedCheckboxes.forEach(checkbox => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'findingIDs[]');
                    hiddenInput.value = checkbox.value;
                    deleteForm.appendChild(hiddenInput);
                });
            });

            deleteModal.querySelector('.btn-danger').addEventListener('click', () => {
                deleteForm.submit();
            });
        });
</script>





</body> 

</html> 