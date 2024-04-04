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
            <form id="clientForm" action="../processes/process_contactus.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" pattern="^[a-zA-Z\s]+$" 
                    title="Name must contain only letters and spaces." required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input required type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email address">
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <div class="mb-3">
                        <label for="message" class="form-label">Message:</label>
                        <input type="text" id="message" name="message" class="form-control" placeholder="Enter message" pattern="^[a-zA-Z0-9_\s]{20,}$" 
                        title="Message must be at least 20 characters long and can contain letters, numbers, and underscores." required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
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
