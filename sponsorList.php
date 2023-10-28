<?php
session_start();
// Include your database connection logic here
include('includes/config.php');

if (isset($_GET['viewid'])) {
    $viewId = $_GET['viewid'];

    // Fetch the details of the selected homeless user
    $sql = "SELECT * FROM homeless_registration WHERE id=:viewId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':viewId', $viewId, PDO::PARAM_INT);
    $query->execute();
    $userDetails = $query->fetch(PDO::FETCH_ASSOC);
}

// Fetch all sponsorships
$sponsorships = array();

$sponsorshipSql = "SELECT sponsorship.*, users.name as sponsor_name, homeless.name as homeless_name
                  FROM sponsorship
                  INNER JOIN users ON sponsorship.sponsor_id = users.id
                  INNER JOIN homeless_registration AS homeless ON sponsorship.homeless_person_id = homeless.id";
$sponsorshipQuery = $dbh->prepare($sponsorshipSql);
$sponsorshipQuery->execute();

while ($result = $sponsorshipQuery->fetch(PDO::FETCH_ASSOC)) {
    $sponsorships[] = $result;
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

    <title>Sponsor List</title>

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
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Sponsor List</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Sponsors</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sponsor Name</th>
                                                <th>Sponsored Homeless Person</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$count = 1;
foreach ($sponsorships as $result) {
    ?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo isset($result['sponsor_name']) ? htmlentities($result['sponsor_name']) : ''; ?></td>
        <td><?php echo isset($result['homeless_name']) ? htmlentities($result['homeless_name']) : ''; ?></td>
        <td><?php echo isset($result['start_date']) ? htmlentities($result['start_date']) : ''; ?></td>
        <td><?php echo isset($result['end_date']) ? htmlentities($result['end_date']) : ''; ?></td>
    </tr>
    <?php
    $count++;
}
?>
                                        </tbody>
                                    </table>
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