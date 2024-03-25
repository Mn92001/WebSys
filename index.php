<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "inc/head.inc.php"; ?>
</head> 


<body>
    <?php include "inc/header.inc.php"; ?> 

    <?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, set a default role
        $role = 'guest';

    } else {
        // Retrieve user information from session variables
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];

        if (isset($_SESSION['approved'])) {
            $status = $_SESSION['approved'];
        } 
    }

    if ($role === 'Client') {
        // Client navigation
        include "inc/navclient.inc.php";
    } elseif ($role === 'Pentester' && $status === 'Approved') {
        // Pentester navigation
        include "inc/navpentester.inc.php";
    } elseif ($role === 'Admin') {
        // Admin navigation
        include "inc/navadmin.inc.php";
    } else {
        // Default navigation for guest
        include "inc/nav.inc.php";
    }

    // Display success message
    if (isset($_SESSION['success'])) {
        $successMsg = $_SESSION['success'];
        unset($_SESSION['success']); 

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . htmlspecialchars($successMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
    } 
    ?>
<main> 
    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
       
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/Homepage.png" alt="Los Angeles" class="d-block" style="width:100%; height: 600px;">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/Homepage2.png" alt="Chicago" class="d-block" style="width:100%; height: 600px;">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/Homepage3.png" alt="New York" class="d-block" style="width:100%; height: 600px;">
                </div>
            </div>

            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        
    </div>
    
</main>     
    <?php include "inc/footer.inc.php"; ?> 
</body> 

</html> 