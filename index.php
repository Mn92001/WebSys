<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "inc/head.inc.php"; ?>
</head> 

<body>
    <?php include "inc/header.inc.php"; ?> 
    <?php include "inc/nav.inc.php"; ?>

    <?php
    session_start();
    if (isset($_SESSION['success'])) {
        $successMsg = $_SESSION['success'];
        unset($_SESSION['success']); 

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . htmlspecialchars($successMsg) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" . "</div>";
    } ?>

    <main class="container">
        <div id="home" class="content">
            <h2>Home</h2>
            <p>Welcome to our pentester services website. We offer a range of services to help secure your digital assets.</p>
        </div>

        <div id="about" class="content">
            <h2>About Us</h2>
            <p>Learn more about our team and our expertise in penetration testing and cybersecurity.</p>
        </div>

        <div id="services" class="content">
            <h2>Our Services</h2>
            <p>Explore the services we offer, including network penetration testing, application security assessments, and more.</p>
        </div>

        <div id="tools" class="content">
            <h2>Our Tools</h2>
            <p>Discover the tools we use for penetration testing and security assessments.</p>
        </div>

        <div id="contact" class="content">
            <h2>Contact Us</h2>
            <p>Get in touch with us to discuss your security needs or to schedule a consultation.</p>
        </div>
    </main>     
    <?php include "inc/footer.inc.php"; ?> 
</body> 

</html> 