<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the signup form is submitted
if (isset($_POST['signup_volunteer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $expertise = $_POST['expertise'];
    $designation = $_POST['designation'];

    // Initialize a message variable
    $volunteerMsg = "";

    // Insert the volunteer details into the database
    try {
        $insertQuery = "INSERT INTO volunteers (name, email, phone, expertise, designation) VALUES (:name, :email, :phone, :expertise, :designation)";
        $insertStatement = $dbh->prepare($insertQuery);
        $insertStatement->bindParam(':name', $name, PDO::PARAM_STR);
        $insertStatement->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStatement->bindParam(':phone', $phone);
        $insertStatement->bindParam(':expertise', $expertise);
        $insertStatement->bindParam(':designation', $designation);
        $insertStatement->execute();

        // Set a success message
        $volunteerMsg = "Thank you for signing up as a volunteer!";
    } catch (PDOException $e) {
        // Handle database-related errors
        $volunteerMsg = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Volunteer</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Adjust the path to your CSS file -->
</head>
<body>
    <header>
        <h1>Welcome to HTH World</h1>
        <p>Helping the Community Together</p>
    </header>

    <?php include('navbar.php'); ?> <!-- Include your website's navigation bar or header -->

    <div class="container">
        <h1>Become a Volunteer</h1>
        <p>Help us make a difference in our community. Sign up as a volunteer!</p>

        <?php if (!empty($volunteerMsg)) : ?>
            <div class="success-message"><?php echo $volunteerMsg; ?></div>
        <?php endif; ?>

        <div class="volunteer-signup-form">
            <form method="post">
                <label for="name">Full Name:</label>
                <input type="text" name="name" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="phone">Phone:</label>
                <input type="tel" name="phone">

                <label for="designation">Role:</label>
                <input type="text" name="designation" required>

                <label for="expertise">Areas of Expertise:</label>
                <textarea name="expertise" rows="4"></textarea>

                <button type="submit" name="signup_volunteer">Sign Up</button>
            </form>
        </div>
    </div>
</br>
</br>
    <?php include('footer.php'); ?> <!-- Include your website's footer -->
</body>
</html>
