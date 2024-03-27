<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "inc/head.inc.php"; ?>
</head> 

<body>

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
                <img src="assets/images/Homepage.png" alt="Vulnerability Testing" class="d-block"> 
                <div class="carousel-caption">
                    <h3> Vulnerability Testing </h3> 
                    <p> Identifying and assessing vulnerabilities in systems, networks and applications
                        to prioritise and remediate security risks
                        Continuous monitoring and vulnerability management: Implementing tools and processes
                        for ongoing vulnerability scanning and management to ensure the security posture 
                        remains robust over time
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/Homepage2.png" alt="Security audit and compliance" class="d-block">
                <div class="carousel-caption">
                    <h3> Security Auditing and Compliance </h3>
                    <p> Conducting security audits and compliance assessments to evaluate adherence to industry
                        standards and regulatory requirements.
                        providing recommendations and guidance to help organisations achieve and maintain compliance
                        with relevant security standards and regulations 
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/Homepage3.png" alt="security product evaluation and testing" class="d-block">
                <div class="carousel-caption">
                    <h3> Security Product Evaluation and Testing </h3>
                    <p> Evaluating the effectiveness and security of third-party security products and solutions, including
                        firewalls, antivirus software, intrusion detection systems and endpoint security tools.
                    </p> 
                </div>
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
    <section class="vulnerability-scanner-info">
        <div class="container">
            <div class="row">
                <div class="col text-section">
                    <h2>Why do you need a website vulnerability scanner?</h2>
                    <ul>
                        <li>Protect your most important sales and marketing tool.</li>
                        <li>Fix weaknesses that could cause downtime, lose sales or damage your brand.</li>
                        <li>Avoid any changes, plugins or new connections adding flaws.</li>
                    </ul>
                </div>
                <div class="col image-section">
                    <img src="assets/images/WebsiteVulnerability.png" alt="Website vulnerability" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section class="security-auditing-and-compliance">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-section order-md-2">
                    <h2>What happens when you use FortifyTech website security scanner?</h2>
                        <p> With a website security scanner you can find any issues as soon as they
                            appear - before attackers do.</p>
                </div> 
                <div class="col-md-6 image-section order-md-1">
                    <img src="assets/images/Security.png" alt="Security auditing and compliance" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="features-section">
    <div class="container">
        <div class="feature">
            <img src="assets/images/stopwatch.png" alt="Setup and Scan Icon" class="feature-icon">
            <h3>Setup and scan in minutes</h3>
            <p>Intruder's online vulnerability scanner is easy to set up and use, all you need to know is what to scan - infrastructure, web apps or APIs.</p>
        </div>
        <div class="feature">
            <img src="assets/images/graph.png" alt="Reduce Attack Surface Icon" class="feature-icon">
            <h3>Reduce your attack surface</h3>
            <p>Intruder continuously scans your network, kicking off vulnerability scans when it sees a change, an unintentionally exposed service, or an emerging threat.</p>
        </div>
        <div class="feature">
            <img src="assets/images/support_icon.png" alt="Best Support Icon" class="feature-icon">
            <h3>The best support, seriously</h3>
            <p>Intruder’s customer support team provides fast, human support so you can solve issues right away.</p>
        </div>
    </div>
    </section>
    <section class="compliance-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 order-lg-2 text-content">
                    <h2>COMPLIANCE</h2>
                    <h1>Meet requirements.<br>Prove it, effortlessly.</h1>
                        <p>Noise filtered, concise and actionable results. Audit ready reports easily show your security posture to auditors, stakeholders and customers. Track your progress including your cyber hygiene score and time to fix issues.</p>
                            <!-- <a href="#" class="btn btn-primary">GET COMPLIANT</a> -->
                </div>
                <div class="col-lg-5 order-lg-1 image-content">
                    <img src="assets/images/compliance.png" alt="compliance icon" class="compliance-icon">
                </div>
            </div>  
        </div>
    </section>


        
</section>


</main>     
    <?php include "inc/footer.inc.php"; ?> 
</body> 

</html> 