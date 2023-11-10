<?php
if (!empty($_GET['tid']) && !empty($_GET['product'])) {
    $GET = filter_var_array($_GET);

    $tid = $GET['tid'];
    $product = $GET['product'];
} else {
    header('Location: donate.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

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

.success-container {
    text-align: center;
    background-color: #333;
    padding: 20px;
    border: 2px solid #debf12; /* Add border */
    box-shadow: 0px 0px 10px #34bcaa; /* Add shadow */
    max-width: 600px; /* Control the width */
    margin: 0 auto; /* Center the container horizontally */
}

.success-container h2 {
    font-size: 24px;
    color: #debf12;
}

.success-container p {
    font-size: 16px;
    color: #fff;
}

    </style>


  <title>Thank You</title>
</head>
<body style="background-color: #333">
    <header>
        <h1>HTH Worldwide</h1>
        <p style="color: #debf12">Every donation is 100% used for our cause!</p>
    </header>

    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
  <div class="container mt-4">
    <h2>Thank you for purchasing <?php echo $product; ?></h2>
    <hr>
  <div class="success-container">
    <p>Your transaction ID is <?php echo $tid; ?></p>
    <p>Check your email for more info</p>
    <p><a href="donate.php" class="btn btn-light mt-2">Go Back</a></p>
  </div>
  </div>
</body>
</html>
