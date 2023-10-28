<?php
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

// Fetch all homeless users
$homelessUsers = array();

$homelessSql = "SELECT h.*, s.sponsor_id, u.name AS sponsor_name
               FROM homeless_registration h
               LEFT JOIN sponsorship s ON h.id = s.homeless_person_id
               LEFT JOIN users u ON s.sponsor_id = u.id";
$homelessQuery = $dbh->prepare($homelessSql);
$homelessQuery->execute();

while ($user = $homelessQuery->fetch(PDO::FETCH_ASSOC)) {
    $homelessUsers[] = $user;
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Homeless List</title>

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
    <?php include('includes/header.php'); // Include your header ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); // Include your left sidebar ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Manage Homeless Users</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Homeless Users List</h4>
                                <table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Sponsor</th> <!-- Add this column -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($homelessUsers as $user) : ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td>
                    <?php
                    if (!empty($user['sponsor_name'])) {
                        echo $user['sponsor_name'];
                    } else {
                        echo "No Sponsor";
                    }
                    ?>
                </td>
                <td>
                    <a href="homelessList.php?viewid=<?php echo $user['id']; ?>">View Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                            </div>
                            <?php if (isset($userDetails)) : ?>
                                <div class="col-md-6">
                                    <h4>Homeless User Details</h4>
                                    <p><strong>Name:</strong> <?php echo $userDetails['name']; ?></p>
                                    <p><strong>Gender:</strong> <?php echo $userDetails['gender']; ?></p>
                                    <p><strong>Age:</strong> <?php echo $userDetails['age']; ?></p>
                                    <p><strong>Special Requirements:</strong> <?php echo $userDetails['special_requirements']; ?></p>
                                    <!-- Add more details as needed -->
                                </div>
                            <?php endif; ?>
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
