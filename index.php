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

    // Retrieve and display error messages
    if (isset($_SESSION['error'])) {
        $errorMsg = $_SESSION['error'];
        unset($_SESSION['error']); 
        
        echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars($errorMsg) . "</div>";
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
                    <h3> Fun Facts about why it's important to do Pen Testing </h3> 
                    <ul>
                        <li>Just as fire drills prepares people for real-life fire situations, pen testing prepares organisations for actual cyberattacks.</li>
                        <li>Pen tester use tools to find sensitive data or scan ports, a bit like cyber detectives.</li>
                        <li>It has a bit of a spy movie element: Pen testers use psychological manipulation to trick people into giving up confidential information.</li>
                    </ul>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/Homepage2.png" alt="Security audit and compliance" class="d-block">
                <div class="carousel-caption">
                    <h3> Top Vulnerabilities </h3>
                    <ul>
                        <li>Broken authentication mechanisms that can allow attackers to use manual or automated methods to control user accounts.</li>
                        <li>Cross-Site Scripting flaws, where attackers execute malicious scripts in a victim's browser.</li>
                        <li>Security misconfigurations, which are the most commonly seen issues</li>
                        <li>Sensitive data exposure due to inadequate encryption or protection</li>
                        <li>Insufficient logging and monitoring, which delays the detection of security breaches.</li>
                    </ul>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/Homepage3.png" alt="security product evaluation and testing" class="d-block">
                <div class="carousel-caption">
                    <h3>Advantages of Pen Testing </h3>
                    <ul> 
                        <li>Uncovers hidden vulnerabilites that routine security checks might miss.</li>
                        <li>Provides a reality check for your security posture by simulating real-world cyberattacks.</li>
                        <li>Assists in compliance with legal and regulatory requirements by identifying and addressing potential security issues.</li>
                        <li>Helps organisations respond to cyberattacks effectively by training their security teams and staff.</li>
                        <li>Protects the brand's reputation and saves potentially millions in costs associated with data breaches.</li>
                    </ul> 
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
            <p>customer support team provides fast, human support so you can solve issues right away.</p>
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
                    <img src="assets/images/compliance.png" alt="compliance icon" class="img-fluid">
                </div>
            </div>  
        </div>
    </section>


        
</section>


</main>     
    <?php include "inc/footer.inc.php"; ?> 
</body> 

</html> 