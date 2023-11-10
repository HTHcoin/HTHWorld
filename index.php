<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTH World</title>
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

        .dropdown-container {
            text-align: center; /* Center the content horizontally */
        }

        .dropdown {
            display: inline-block;
            position: relative;
            margin-right: 20px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .service {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #333;
            color: #fff;
        }

        .service.active {
            display: block;
        }

        /* Styling for the dropdown links */
        .dropdown-content a {
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            color: #34bcaa;
            background-color: #333;
        }

        .dropdown-content a:hover {
            background-color: #333;
            color: #debf12;
        }

        .about-container {
            text-align: center;
            background-color: #333;
            padding: 20px;
        }

        .about-container h2 {
            font-size: 24px;
            color: #debf12;
        }

        .about-container p {
            font-size: 16px;
            color: #fff;
        }

        .donate-container {
            text-align: center; /* Center the content horizontally */
        }
        .donate-container {
            text-align: center;
            background-color: #333;
            padding: 20px;
        }

        .donate-container h2 {
            font-size: 24px;
            color: #debf12;
        }

        .donate-container p {
            font-size: 16px;
            color: #fff;
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


    </style>
</head>
<body style="background-color: #333">
    <header>
        <h1>Welcome to HTH World</h1>
        <p style="color: #debf12">Helping the Community Together</p>
    </header>

    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
    <main>
        <div class="dropdown-container">
    <div class="options-section">
        <h2> HTH Services</h2>
        <p>At HTH We Fully Believe Everyone Desrves A Chance! Make A Change Today Or Seek Help Today!</p>
    </div>
        <div class="dropdown">
            <h2>Get Involved!</h2>
            <div class="dropdown-content">
                <a href="#" class="show-service" data-service="donate">Donate</a>
                <a href="#" class="show-service" data-service="fundraisers">Fundraisers</a>
                <a href="#" class="show-service" data-service="volunteer">Volunteer</a>
                <a href="#" class="show-service" data-service="services">HTH World</a>
            </div>
        </div>

        <div class="dropdown">
    <h2>Need Assistance?</h2>
    <div class="dropdown-content">
        <a href="#" class="show-service" data-service="food-banks">Food Banks</a>
        <a href="#" class="show-service" data-service="shelters">Shelters</a>
        <a href="#" class="show-service" data-service="homeless">Homeless</a> <!-- New service link for Homeless -->
        <a href="#" class="show-service" data-service="charities">Charities</a>
    </div>
</div>

        <div class="service" id="donate">
            <h3>Donate Today</h3>
            <p>100% of your donation goes towards helping the homeless, please donate today!</p>
            <a href="donate.php" class="service-link">Donate Now</a>
        </div>

        <div class="service" id="fundraisers">
            <h3>Fundraisers</h3>
            <p>Donate to a specific cause!</p>
            <a href="fundraiser.php" class="service-link">Fundraisers</a>
        </div>

        <div class="service" id="volunteer">
            <h3>Volunteer</h3>
            <p>Join the HTH Family and become a Volunteer today and help make an impact in your area!</p>
            <a href="volunteer.php" class="service-link">Volunteer Now</a>
        </div>

       <div class="service" id="homeless">
           <h3>Homeless Services</h3>
           <p>Provide assistance to homeless individuals and make a difference in their lives.</p>
           <a href="homeless.php" class="service-link">Learn More</a>
        </div>

        <div class="service" id="food-banks">
            <h3>Food Banks</h3>
            <p>Need to locate your closest food bank? Check out HTH World!</p>
            <a href="world.php?service_type=food_bank" class="service-link">Learn More</a>
        </div>

        <div class="service" id="shelters">
            <h3>Shelters</h3>
            <p>Need Shelter? Check out HTH World!</p>
            <a href="world.php?service_type=shelter" class="service-link">Learn More</a>
        </div>

        <div class="service" id="charities">
            <h3>Charities</h3>
            <p>Need to find a charity near you? Check out HTH World</p>
            <a href="world.php?service_type=organization" class="service-link">Learn More</a>
        </div>
        <div class="service" id="services">
            <h3>HTH World</h3>
            <p>Join HTH World to Get involved today through user experience!</p>
            <a href="services.php" class="service-link">HTH World</a>
        </div>
        </div>
</br>
</br>
        <div class="about-container">
            <h2>Our Goal</h2>
            <p>HTH World is a platform where those who are less fortunate have an easy place to come when they need assistance. We believe in keeping things as simple as possible in order to achieve success!</p>
        </div>
    <div class="about-container">
        <h2> Donate Right Now!</h2>
        <p>100% of your donation goes towards helping the homeless, please donate today!</p>
    </div>
        <div class="donate-container">
      <div class="donate-container">
<!-- Stripe Donate Now Button -->
<a href="https://buy.stripe.com/eVa00f4LjbLrfBu5kk" class="donate-button" target="_blank">Stripe</a>

<!-- PayPal Donate Now Button -->
<a href="https://www.paypal.com/paypalme/hthworldwide" class="donate-button" target="_blank">PayPal</a>
        </div>
</div>
    </main>
</br>
</br>
    <?php
    // Include the footer
    include('footer.php');
    ?>

    <script>
        document.querySelectorAll('.show-service').forEach(function (element) {
            element.addEventListener('click', function () {
                var serviceId = this.getAttribute('data-service');
                document.querySelectorAll('.service').forEach(function (service) {
                    service.classList.remove('active');
                });
                document.getElementById(serviceId).classList.add('active');
            });
        });
    </script>
</body>
</html>
