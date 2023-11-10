<?php
session_start();
include('includes/config.php'); // Include your database connection logic here

// Fetch donors
$donors = array();

try {
    $donorSql = "SELECT * FROM donations";
    $donorQuery = $dbh->prepare($donorSql);
    $donorQuery->execute();

    while ($donor = $donorQuery->fetch(PDO::FETCH_ASSOC)) {
        $donors[] = $donor;
    }
} catch (PDOException $e) {
    // Handle database-related errors when fetching donors
    $donorMsg = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Donors List</title>

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
}

.heading {
font-size: 18px;
font-family: Arial, sans-serif;
color: #34bcaa;
background-color: #333;
}

.list-body {

background-color: #333;
}
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Donors List</h2>
                    </div>
                </div>
</br>
</br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
</br>
                            <div class="heading">Donors</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <?php if (!empty($donorMsg)) : ?>
                                        <div class="errorWrap">
                                            <?php echo $donorMsg; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($donors)) : ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Donor Name</th>
                                                    <th>Email</th>
                                                    <th>Donation Amount</th>
                                                    <th>Donation Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($donors as $donor) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo htmlentities($donor['donor_name']); ?></td>
                                                        <td><?php echo htmlentities($donor['donor_email']); ?></td>
                                                        <td><?php echo htmlentities($donor['donation_amount']); ?></td>
                                                        <td><?php echo htmlentities($donor['donation_date']); ?></td>
                                                    </tr>
                                                    <?php
                                                    $count++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php else : ?>
                                        <p>No donors found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- Loading Scripts -->
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
