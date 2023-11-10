<?php
session_start();
include('includes/config.php');
  require_once('lib/pdo_db.php');
  require_once('models/Transaction.php');

  // Instantiate Transaction
  $transaction = new Transaction();

  // Get Transaction
  $transactions = $transaction->getTransactions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Style -->
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

h4 {
text-align: center;
color: #34bcaa;
}


th {
text-align: center;
color: #34bcaa;
}

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        color: #debf12;
        border-color: #34bcaa;
        border: 2px solid #34bcaa; /* Add border */
        box-shadow: 0 0 10px #debf12;
    }

.card-section {
    text-align: center;
    margin: 0 auto;
    background: #333;
    color: #debf12;
    border-radius: 6px;
    padding: 20px;
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    width: 80%; /* Adjust the width as needed */
}

    </style>


  <title>View Transactions</title>
</head>
<body>
</br>
</br>

    <?php include('includes/header.php'); // Include your header ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); // Include your left sidebar ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title" style="color: #debf12">HTH Donors List</h3>

</br>
    <table class="table">
      <thead>
        <tr>
          <th>Transaction ID</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Amount</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($transactions as $t): ?>
          <tr>
            <td><?php echo $t->id; ?></td>
            <td><?php echo $t->customer_id; ?></td>
            <td><?php echo $t->product; ?></td>
            <td><?php echo sprintf('%.2f', $t->amount / 100); ?> <?php echo strtoupper($t->currency); ?></td>
            <td><?php echo $t->created_at; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    <div class="card-section">
        <h2> Donate Right Now!</h2>
        <p>100% of your donation goes towards helping the homeless, please donate today!</p>
    <p><a href="donate.php" style="color: #34bcaa">Donate Here!</a></p>
    </div>
  </div>
</div>
</div>
</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(function () {
                $('.succWrap').slideUp("slow");
            }, 3000);
        });
    </script>
</body>
</html>