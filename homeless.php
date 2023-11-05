<?php
// Include your database connection logic here
include('includes/config.php');

// Check if the registration form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $special_requirements = $_POST['special_requirements'];

    // Insert the data into the database
    $sql = "INSERT INTO homeless_registration (name, gender, age, special_requirements) VALUES (:name, :gender, :age, :special_requirements)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_INT);
    $query->bindParam(':special_requirements', $special_requirements, PDO::PARAM_STR);

    if ($query->execute()) {
        // Registration successful
        echo "<script>alert('Registration successful.');</script>";
    } else {
        // Registration failed
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HTH World</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add any additional styles you need */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            font-size: 36px;
        }

        p {
            font-size: 18px;
        }

        .main {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            text-align: center;
            margin: 20px 0;
        }

        .registration-popup {
            display: none;
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button {
            width: 30%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2773a4;
        }

        .popup-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to HTH World</h1>
        <p>Helping the Community Together</p>
    </header>
    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
    <main class="main">
        <!-- Display the welcome message for homeless individuals -->
        <div class="welcome-message">
            <h2>Welcome to HTH World</h2>
            <p>If you are experiencing homelessness, you can sign up with HTH World and gain easy access and verification. You may also have the opportunity to get sponsored by a registered user. We are here to help you!</p>
        </div>
<div class="welcome-message">
    <h2>Welcome to HTH World</h2>
    <p>If you want to sponsor a homeless individual and make a positive impact, click the button below.</p>
    <a href="sponsor.php" class="btn btn-primary">Sponsor Now</a>
</div>
    </main>

    <!-- Registration Form Pop-up -->
    <div class="registration-popup">
        <h3>Register as a Homeless Individual</h3>
        <form method="post" class="form-horizontal" name="regform" onSubmit="return validate();">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Gender<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <select name="gender" class="form-control" required>
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Age<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="age" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Special Requirements</label>
                <div class="col-sm-10">
                    <textarea name="special_requirements" class="form-control"></textarea>
                </div>
            </div>

            <!-- Add any additional fields you need for registration -->

            <button class="btn btn-primary" name="submit" type="submit">Register</button>
        </form>
        <button id="close-registration-popup">Close</button>
    </div>

    <div class="popup-button">
        <button class="btn btn-primary" id="show-registration-popup">Sign Up</button>
    </div>

    <!-- Add your JavaScript for the pop-up registration form here -->
    <script>
        // JavaScript to display and hide the registration pop-up
        function showRegistrationPopup() {
            var popup = document.querySelector('.registration-popup');
            popup.style.display = 'block';
        }

        function hideRegistrationPopup() {
            var popup = document.querySelector('.registration-popup');
            popup.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Add event listeners to show/hide the registration pop-up
            var showButton = document.querySelectorAll('#show-registration-popup');
            var closeButton = document.querySelector('#close-registration-popup');

            showButton.forEach(function(button) {
                button.addEventListener('click', showRegistrationPopup);
            });

            closeButton.addEventListener('click', hideRegistrationPopup);
        });
    </script>
</body>
</html>