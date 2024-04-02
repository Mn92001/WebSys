<!DOCTYPE html>
<html lang="en">

<head>
    <title>FortifyTech - About us</title>
    <link rel="stylesheet" href="about_us.css">
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <?php include "../inc/head.inc.php"; ?>
</head>

<body> 
    <header>
        <h1> About us </h1> 
    </header>
    <?php include "../inc/nav.inc.php"; ?>
    

    <!-- About Us Section -->
    <section id="about-us" class="image-section">
    <img src="assets/images/about_us.png" alt="About Us Image" class="about-us-image">
        <div class="image-text">
            <h2>About Us</h2>
        </div>
    </section>

    <!-- Home Section with Mission, Vision, Goal Cards -->
    <div class="container">
        <div class="card mission">
            <div class="card-content">
                <p class="card-title">Mission</p>
                <p class="card-para">To provide top-notch pen testing services to fortify our clients' digital defenses.</p>
            </div>
        </div>
        
        <div class="card vision">
            <div class="card-content">
                <p class="card-title">Vision</p>
                <p class="card-para">To become a global leader in cybersecurity by delivering innovative solutions and unparalleled expertise.</p>
            </div>
        </div>
        
        <div class="card goal">
            <div class="card-content">
                <p class="card-title">Goal</p>
                <p class="card-para">To ensure the security and peace of mind of our clients by staying ahead of emerging cyber threats.</p>
            </div>
        </div>
    </div>
    <!-- Home Section Ends -->

    <!-- Our Team Section Starts -->
    <section id="our-Team">
        <div class="container-fluid">
            <h2 class="section-title">Our Team</h2>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="team-container">
                        <h4>John Smith</h4>
                        <p>Position: Penetration Tester</p>
                        <!-- Additional content for top left block -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-container">
                        <h4>Emily Johnson</h4>
                        <p>Position: Cybersecurity Analyst</p>
                        <!-- Additional content for top right block -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-container">
                        <h4>Michael Brown</h4>
                        <p>Position: Security Consultant</p>
                        <!-- Additional content for team member 1 -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-container">
                        <h4>Sarah Davis</h4>
                        <p>Position: Ethical Hacker</p>
                        <!-- Additional content for team member 2 -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-container">
                        <h4>David Lee</h4>
                        <p>Position: Cybersecurity Engineer</p>
                        <!-- Additional content for team member 3 -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Team Section Ends -->

    <!-- What Our Pen-Tested Company Does Section Starts -->
    <section id="what-we-do">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="what-we-do-container">
                        <h2>What We Do</h2>
                        <p>At FortifyTech, we specialize in providing comprehensive penetration testing services to fortify the digital defenses of our clients. Our team of experts is dedicated to staying ahead of emerging cyber threats and delivering innovative solutions to ensure the security and peace of mind of our clients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- What Our Pen-Tested Company Does Section Ends -->

    <?php include "../inc/footer.inc.php"; ?>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
