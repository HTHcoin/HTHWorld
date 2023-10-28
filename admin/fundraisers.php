<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['create_fundraiser'])) {
        $campaign_name = $_POST['campaign_name'];
        $organizer = $_POST['organizer'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $goal_amount = $_POST['goal_amount'];

        $insertQuery = "INSERT INTO fundraisers (campaign_name, organizer, start_date, end_date, goal_amount, progress) VALUES (:campaign_name, :organizer, :start_date, :end_date, :goal_amount, 0.00)";

        $insertStatement = $dbh->prepare($insertQuery);
        $insertStatement->bindParam(':campaign_name', $campaign_name, PDO::PARAM_STR);
        $insertStatement->bindParam(':organizer', $organizer, PDO::PARAM_STR);
        $insertStatement->bindParam(':start_date', $start_date);
        $insertStatement->bindParam(':end_date', $end_date);
        $insertStatement->bindParam(':goal_amount', $goal_amount);
        $insertStatement->execute();

        // Add code to display a success message if necessary
    }

    // Fetch fundraisers
    $fundraisers = array();
    $fundraiserMsg = "";  // Message to display fundraisers

    $fundraiserSql = "SELECT * FROM fundraisers";
    $fundraiserQuery = $dbh->prepare($fundraiserSql);
    $fundraiserQuery->execute();

    while ($fundraiser = $fundraiserQuery->fetch(PDO::FETCH_ASSOC)) {
        $fundraisers[] = $fundraiser;
    }
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Edit Fundraisers</title>

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
    <link rel="stylesheet" href="css/fundraisers.css">
    <script type="text/javascript" src="../vendor/countries.js"></script>
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
    </style>
</head>

<body>
    <?php
    $sql = "SELECT * from admin;";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $cnt = 1;
    ?>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Manage Fundraisers</h3>
                        <div class="row">
                            <!-- "Menu Form" -->
                            <div class="col-md-15">
                                <h4>Create New Fundraiser</h4>
                                <form method="post">
                                    <label for="campaign_name">Campaign Name</label>
                                    <input type="text" name="campaign_name" required>

                                    <label for="organizer">Organizer</label>
                                    <input type="text" name="organizer" required>

                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" required>

                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" required>

                                    <label for="goal_amount">Goal Amount</label>
                                    <input type="number" name="goal_amount" required>

                                    <button type="submit" name="create_fundraiser">Create Fundraiser</button>
                                </form>
                            </div>
                        </div>
                        </br>
                        </br>
                        <!-- "Fundraisers List" -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($fundraisers)) : ?>
                                    <h4>Fundraisers List</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Campaign Name</th>
                                                <th>Organizer</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Goal Amount</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($fundraisers as $fundraiser) : ?>
                                                <tr>
                                                    <td><?php echo $fundraiser['campaign_name']; ?></td>
                                                    <td><?php echo $fundraiser['organizer']; ?></td>
                                                    <td><?php echo $fundraiser['start_date']; ?></td>
                                                    <td><?php echo $fundraiser['end_date']; ?></td>
                                                    <td><?php echo $fundraiser['goal_amount']; ?></td>
                                                    <td><?php echo $fundraiser['progress']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No fundraisers found.</p>
                                <?php endif; ?>
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
<?php } ?>
