<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HTH Services</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            color: #debf12;
        }

        p {
            font-size: 18px;
            color: #fff;
        }

        ol {
            list-style-type: decimal;
            text-align: left;
        }

        li {
            font-size: 16px;
            color: #fff;
            margin: 10px 0;
            text-align: center;
        }

        a {
            color: #34bcaa;
            text-decoration: none;
        }
    </style>
</head>
<body style="background-color: #333">
    <header>
        <h1>Welcome to HTH World</h1>
        <p>Helping the Community Together</p>
    </header>

    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
    <!-- Create Account Section -->
    <h2>Create an Account</h2>
    <p>If you're new to HTH World, the first step is to create an account. Follow these simple steps:</p>
    <ol>
        <li>Click the <a href="register.php">Create Account</a></li>
        <li>Fill out the registration form with your information.</li>
        <li>Submit the form to create your account.</li>
        <li>You'll receive a confirmation email once your account is created.</li>
    </ol>
</br>
    <!-- Become an Employer Section -->
    <h2>Become an Employer</h2>
    <p>As an employer, you can offer job opportunities to individuals. Here's how to get started:</p>
    <ol>
        <li>Create an account following the steps above.</li>
        <li>Once registered, <a href="login.php">Log In</a></li>
        <li>Access the "Employer Dashboard" to post job openings.</li>
        <li>Provide job details and any specific requirements.</li>
        <li>Submit the job listing for potential employees to view.</li>
    </ol>
</br>
    <!-- Become an Employee Section -->
    <h2>Become an Employee</h2>
    <p>If you're seeking employment opportunities, HTH Services can help. Here's how to proceed:</p>
    <ol>
        <li>Create an account following the steps above.</li>
        <li>Once registered, log in to your account.</li>
        <li>Access the "Employee Dashboard" to search for available jobs.</li>
        <li>Browse job listings and apply to those that match your skills and interests.</li>
        <li>Employers may contact you through the platform for interviews and job offers.</li>
    </ol>
</br>
</br>
    <?php
    // Include the footer
    include('footer.php');
    ?>
</body>
</html>
