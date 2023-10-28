<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Customize these settings for your email configuration
    $to = "hthcoin@gmail.com";  // Replace with your email address
    $subject = "Contact Form Submission from $name";
    $headers = "From: $email";
    $messageBody = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Send the email
    $sent = mail($to, $subject, $messageBody, $headers);

    if ($sent) {
        // Email sent successfully
        echo '<div class="success">Your message has been sent successfully.</div>';
    } else {
        // Email not sent
        echo '<div class="error">Sorry, there was an issue sending your message. Please try again later.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: #333">
    <header>
        <h1>Contact Us</h1>
        <p>If you have any questions or would like to get involved, please fill out the form below:</p>
    </header>

    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
    <main>
        <section id="contact-form">
            <form action="contact.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for "email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <a id="send-email" class="mailto-link">
                    <button type="button">Send</button>
                </a>
            </form>
        </section>
    </main>

    <?php
    // Include the footer
    include('footer.php');
    ?>

    <script>
        document.getElementById("send-email").addEventListener("click", function () {
            var name = encodeURIComponent(document.getElementById("name").value);
            var email = encodeURIComponent(document.getElementById("email").value);
            var message = encodeURIComponent(document.getElementById("message").value);

            var mailtoLink = "mailto:hthcoin@gmail.com" +
                "?subject=Contact Form Submission" +
                "&body=Name: " + name +
                "%0AEmail: " + email +
                "%0AMessage:%0A" + message;

            this.href = mailtoLink;
        });
    </script>
</body>
</html>

