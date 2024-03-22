<!DOCTYPE html>
<html lang="en">

<head>
    <title> Pentester - Contact Us </title> 
    <?php include "inc/head.inc.php"; ?>
</head> 


<body> 
    <header>
        <h1> Contact Us </h1> 
    </header>
    <?php include "inc/nav.inc.php"; ?>
    <main>
        <section id="contact-form">
            <h2>Send us a message</h2>
            <form action="submit.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" class="form-control" required></textarea>

                <button type="submit">Send</button>
            </form>
        </section>

        <section id="contact-info">
            <h2>Contact Information</h2>
            <p>If you prefer to reach out to us directly, you can use the contact information below:</p>
            <p>Email: contact@yourpentestercompany.com</p>
            <p>Phone: 123-456-7890</p>
            <p>Address: 123 Main Street, City, Country</p>
        </section>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>
</html> 