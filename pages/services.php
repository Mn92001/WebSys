<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pentester - Our Services</title>
    <link rel="stylesheet" href="services.css">
    <?php include "../inc/head.inc.php"; ?>
</head>

<body>
    <?php include "../inc/nav.inc.php"; ?>
    <main>
        <section id="service1" class="blue-bg">
            <div class="service-section">
                <div class="box" onclick="scrollToSection('service2')">
                    <img src="assets\images\services (1).jpg" alt="Vulnerability Assessment">
                    <p>Vulnerability Assessment</p>
                </div>
                <div class="box" onclick="scrollToSection('service3')">
                    <img src="assets\images\services (2).jpg" alt="Penetration Testing">
                    <p>Penetration Testing</p>
                </div>
                <div class="box" onclick="scrollToSection('service4')">
                    <img src="assets\images\services (3).jpg" alt="Security Audit">
                    <p>Security Audit</p>
                </div>
                <div class="box" onclick="scrollToSection('service5')">
                    <img src="assets\images\services (4).jpg" alt="Security Training">
                    <p>Security Training</p>
                </div>
            </div>
        </section>

        <section id="service2" class="white-bg">
            <div class="service-section">
                <div class="big-image">
                    <img src="assets\images\Vulnerability.jpg" alt="Vulnerability Assessment">
                </div>
                <div class="textbox">
                    <h2>Vulnerability Assessment</h2>
                    <p>A vulnerability assessment is the process of identifying, quantifying, and prioritizing the vulnerabilities in a system. It's a proactive approach to understanding and addressing potential weaknesses before they can be exploited by attackers. Our team conducts comprehensive vulnerability assessments to help you strengthen your security posture and protect your digital assets.</p>                
                </div>
            </div>
        </section>

        <section id="service3" class="blue-bg">
            <div class="service-section">
                <div class="textbox">
                    <h2>Penetration Testing</h2>
                    <p>Penetration testing, also known as pen testing, is a simulated cyberattack against a computer system to check for exploitable vulnerabilities. It's an essential component of a comprehensive security strategy and helps organizations identify and address security weaknesses before malicious actors can exploit them.</p>                
                </div>
                <div class="big-image">
                    <img src="assets\images\Penetration.jpg" alt="Penetration Testing">
                </div>
            </div>
        </section>

        <section id="service4" class="white-bg">
            <div class="service-section">
                <div class="big-image">
                    <img src="assets\images\SecurityAudit.jpg" alt="Security Audit">
                </div>
                <div class="textbox">
                    <h2>Security Audit</h2>
                    <p>A security audit is an extensive review of an organization's security policies, procedures, and controls. It helps identify gaps in security and assesses the effectiveness of existing security measures. Our team conducts thorough security audits to help organizations enhance their security posture and protect against potential threats.</p>                
                </div>
            </div>
        </section>

        <section id="service5" class="blue-bg">
            <div class="service-section">
                <div class="textbox">
                    <h2>Security Training</h2>
                    <p>Security training is essential for educating employees about cybersecurity best practices and reducing the risk of security incidents. Our customized security training programs cover topics such as phishing awareness, password security, and data protection, empowering employees to contribute to a secure work environment.</p>                
                </div>
                <div class="big-image">
                    <img src="assets\images\SecurityTraining.jpg" alt="Security Training">
                </div>
            </div>
        </section>
        
    </main>
    <?php include "../inc/footer.inc.php"; ?>

    <script>
        function scrollToSection(sectionId) {
            var section = document.getElementById(sectionId);
            section.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>
