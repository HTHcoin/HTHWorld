<?php
session_start();
include('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>

       .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #dd3d36;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #5cb85c;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

h2 {
text-align: center;
color: #34bcaa;
}

    .donate-button {
        display: inline-block;
        background-color: #34bcaa;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        margin: 10px;
        box-shadow: 0 0 10px #debf12;
    }

    .donate-button:hover {
        background-color: #debf12;
        box-shadow: 0 0 10px #34bcaa;
    }

        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #debf12;
        }

.about-container {
    text-align: center;
    background-color: #333;
    padding: 20px;
    border: 2px solid #debf12; /* Add border */
    box-shadow: 0px 0px 10px #34bcaa; /* Add shadow */
    max-width: 600px; /* Control the width */
    margin: 0 auto; /* Center the container horizontally */
}

.about-container h2 {
    font-size: 24px;
    color: #debf12;
}

.about-container p {
    font-size: 16px;
    color: #fff;
}

        .donation-form {
            display: inline-block;
            width: 45%; /* Each form takes up 45% of the container width */
            padding: 20px;
            background-color: #333;
            border: 2px solid #debf12; /* Add border */
            box-shadow: 0 0 10px #34bcaa; /* Add shadow */
            max-width: 600px; /* Control the width */
            margin: 0 5px; /* Add some margin between the forms */
        }

form label {
    display: block;
    font-weight: bold;
    margin: 10px 0;
    color: #debf12;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

button, input, optgroup, select, textarea {
    margin: 5px;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}

    </style>


  <title>Donate Today!</title>
</head>
<body style="background-color: #333">
    <header>
        <h1>HTH Donations</h1>
        <p style="color: #debf12">To Donate to HTH, please fill out the form below:</p>
    </header>

    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
    <div class="donation-form">
        <!-- Donation form content for the left side -->
        <h2 class="my-4 text-center">Donate Today!</h2>
        <form action="./charge.php" method="post" id="payment-form">
            <!-- Donation form elements here -->
            <div class="form-row">
                <input type="text" name="first_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="First Name">
                <input type="text" name="last_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Last Name">
                <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Email Address">
                <label for="donation_amount">Donation Amount:</label>
                <select name="donation_amount" id="donation_amount">
                    <option value="1">$1</option>
                    <option value="5">$5</option>
                    <option value="10">$10</option>
                    <option value="20">$20</option>
                    <option value="50">$50</option>
                    <option value="100">$100</option>
                    <!-- Add more options as needed -->
                </select>
                <div id="card-element" class="form-control">
                    <!-- a Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
            </div>
            <button>Submit Payment</button>
        </form>
    </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="./js/charge.js"></script>

</body>
</html>