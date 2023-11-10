<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $user_id = $_SESSION['id']; // Get the logged-in user's ID

    if (isset($_GET['apply'])) {
        $jobId = $_GET['apply'];

        // You can implement the job application logic here, such as saving the application to the database.
        // Make sure to collect all necessary details, like a cover letter, resume, etc.
        // Insert the application into a table called 'job_applications' or something similar.

        $msg = "Job application submitted successfully";
    }

    // Fetch job listings from the 'jobs' table
    $sql = "SELECT * FROM jobs";
    $query = $dbh->prepare($sql);
    $query->execute();
    $jobListings = $query->fetchAll(PDO::FETCH_OBJ);
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
    <title>Job Listings</title>

    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery (update the version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript (update the version) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>

th {
text-align: center;
color: #34bcaa;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
    color: #debf12;
    background-color: #333;
}

.modal-content {
    position: relative;
    background-color: #333;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
}

.modal-header {
    padding: 15px;
    border-bottom: 1px solid #34bcaa;
}

.modal-footer {
    display: contents;
    grid-template-columns: 1fr; /* Create a single column */
    grid-template-rows: 1fr auto 1fr; /* Create three rows with equal spacing */
    align-content: center; /* Vertically align content to the center */
    padding: 15px;
    border-top: 1px solid #34bcaa;
}

    .button-default {
        display: inline-block;
        background-color: #34bcaa;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        margin: 10px;
        box-shadow: 0 0 10px #debf12;
        width: 25%;
    }

    .button-default:hover {
        background-color: #debf12;
        box-shadow: 0 0 10px #34bcaa;
    }

    .button-primary {
        display: inline-block;
        background-color: #34bcaa;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        margin: 10px;
        box-shadow: 0 0 10px #debf12;
        text-align: center;
        width: 25%;
    }

    .button-primary:hover {
        background-color: #debf12;
        box-shadow: 0 0 10px #34bcaa;
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
                        <h2 class="page-title">Job Listings</h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if ($msg) { ?>
                                    <div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?></div>
                                <?php } ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Location</th>
                                            <th>Salary</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jobListings as $job) {
                                        ?>
                                            <tr>
                                                <td><?php echo htmlentities($job->job_title); ?></td>
                                                <td><?php echo htmlentities($job->location); ?></td>
                                                <td><?php echo htmlentities($job->salary); ?></td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#jobDetails<?php echo $job->id; ?>">View Details</a>
                                                </td>
                                            </tr>

                                            <!-- Job Details Modal -->
                                            <div class="modal fade" id="jobDetails<?php echo $job->id; ?>" tabindex="-1" role="dialog" aria-labelledby="jobDetailsLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="jobDetailsLabel">Job Details</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Job Title:</strong> <?php echo htmlentities($job->job_title); ?></p>
                                                            <p><strong>Location:</strong> <?php echo htmlentities($job->location); ?></p>
                                                            <p><strong>Salary:</strong> <?php echo htmlentities($job->salary); ?></p>
                                                            <p><strong>Description:</strong> <?php echo htmlentities($job->job_description); ?></p>
                                                            <p><strong>Requirements:</strong> <?php echo htmlentities($job->requirements); ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="button-default" data-dismiss="modal">Close</button>
                                                            <a href="application.php?apply=<?php echo $job->id; ?>" class="button-primary">Apply</a>
                                                        </div>
</br>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
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
