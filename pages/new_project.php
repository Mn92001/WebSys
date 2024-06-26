<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Project</title>
    <?php include "../inc/clientcheck.inc.php";?>
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/navclient.inc.php";?> 
    <?php include "../inc/session.inc.php"; ?>
    <link rel="stylesheet" href="/assets/css/new_project.css">
</head>

<body>
    <main class="container">
        <div class="row content-container">
            <h1>New Project</h1>
            <p>
                To check on existing projects, please go to the
                <a href="../pages/project_status.php">Project Status page</a>.
            </p>

            <?php if (!empty($errorMsg)): ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($errorMsg); ?>
                </div>
            <?php endif; ?>

           
            <div class= "form-container">
                <form  action="../processes/new_project.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Project Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Project Name" pattern="^[a-zA-Z0-9_]{5,}$" 
                        title="Project name must be at least 5 characters long and can contain letters, numbers, and underscores." required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Project Description:</label>
                        <input type="text" id="description" name="description" class="form-control" placeholder="Enter Project Description" pattern="^[a-zA-Z0-9_\s]{20,}$" 
                        title="Project description must be at least 20 characters long and can contain letters, numbers, and underscores." required>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Project Expiry Date:</label>
                        <input type="date" id="expiryDate" name="expiryDate" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="coinsOffered" class="form-label">Coins Offered:</label>
                        <input type="text" id="coinsOffered" name="coinsOffered" class="form-control" placeholder="Enter a number" pattern="\d+"
                        title="Coins offered must contain only numbers.">
                    </div>
                    <div class="mb-3">
                        <label for="roePdf" class="form-label">Rules of Engagement (PDF):</label>
                        <input type="file" id="roePdf" name="roePdf" class="form-control" accept="application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="scopePdf" class="form-label">Scope (PDF):</label>
                        <input type="file" id="scopePdf" name="scopePdf" class="form-control" accept="application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="completionDate" class="form-label">Expected Completion Date:</label>
                        <input type="date" id="completionDate" name="completionDate" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div> 
        </div> 
        
    </main>   

</body> 

<?php include "../inc/footer.inc.php"; ?> 
</html> 
