<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    $_SESSION = array();
    session_destroy();
?>


<head>
    <title> Pentester - Contact Us </title> 
    <?php include "../inc/head.inc.php"; ?>
    <?php include "../inc/nav.inc.php"; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #88ccec;
            color: #333;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
        }

        h2 {
            color: #007bff;
        }

        .contact-box {
            flex-basis: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #contact-info {
            flex-basis: calc(50% - 20px);
            margin-left: 20px;
        }

        #contact-info p {
            margin-bottom: 10px;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            #contact-info {
                flex-basis: 100%;
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head> 



<body> 
    <main>
        <section id="contact-form" class="contact-box">
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

        <section id="contact-info" class="contact-box">
            <h2>Contact Information</h2>
            <p>If you prefer to reach out to us directly, you can use the contact information below:</p>
            <p>Email: contact@fortifytech.com</p>
            <p>Phone: 123-456-7890</p>
            <p>Address: 123 Main Street, Singapore, 977651</p>
            <div id="map">
                <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=%20Tampines%20New%20Town+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                <a href='https://www.embedmap.net/'>google map widget</a> 
                <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=47c9ac95dae9194c5a4db97a973fe8b23e4f3519'></script>
            </div>
        </section>
    </main>
    <?php include "../inc/footer.inc.php"; ?>
</body>
</html> 
