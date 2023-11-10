<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
   <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name "author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>Employers Dashboard</title>

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

    </head>
<body>
    <!-- Include your header and sidebar here as per your template -->
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Employers </h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Register as an Employer</h3>
                                <p>Register as an employer to post job listings for job seekers.</p>
                                <a href="employers.php" class="btn btn-primary">Register as an Employer</a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Create Job Listings</h3>
                                <p>Create job listings for your organization and reach potential candidates.</p>
                                <a href="create-jobs.php" class="btn btn-primary">Create Job Listings</a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Applicants</h3>
                                <p>View Applications.</p>
                                <a href="applicant.php" class="btn btn-primary">Applications</a>
                            </div>
                        </div>
                        <!-- Add a section to display the list of jobs here -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Job Listings</h3>
                                <p>View the job listings you've created:</p>
                                <a href="job-listings.php" class="btn btn-primary">View Job Listings</a>
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
<?php
}
?>
