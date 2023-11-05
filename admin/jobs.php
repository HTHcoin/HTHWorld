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
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name "author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Job Listings</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .job-details {
            display: none;
            position: absolute;
            background: #fff;
            padding: 15px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px #000;
            z-index: 999;
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
                        <div class="job-listings">
                            <?php
                            // Retrieve job listings from your database and display them here
                            $jobListingsSql = "SELECT * FROM jobs";
                            $jobListingsQuery = $dbh->prepare($jobListingsSql);
                            $jobListingsQuery->execute();
                            $jobListings = $jobListingsQuery->fetchAll(PDO::FETCH_ASSOC);

                            if (count($jobListings) > 0) {
                                echo '<ul>';
                                foreach ($jobListings as $job) {
                                    echo '<li><a href="#" class="job-listing-link" data-jobid="' . $job['id'] . '">' . htmlentities($job['job_title']) . '</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                echo 'No job listings found.';
                            }
                            ?>
                        </div>
                        <?php
                        if (count($jobListings) > 0) {
                            foreach ($jobListings as $job) {
                                echo '<div class="job-details" id="job-details-' . $job['id'] . '">';
                                echo '<button class="close-button" onclick="closeJobDetails(' . $job['id'] . ')">Close</button>';
                                echo '<h3>' . htmlentities($job['job_title']) . '</h3>';
                                echo '<p>' . nl2br(htmlentities($job['job_description'])) . '</p>';
                                echo '<p>Location: ' . htmlentities($job['location']) . '</p>';
                                echo '<p>Salary: $' . number_format($job['salary'], 2) . '</p>';
                                // Add more job details here
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include your JavaScript files here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script>
        function closeJobDetails(jobID) {
            $('#job-details-' + jobID).hide();
        }

        $(document).ready(function () {
            $('.job-listing-link').click(function (e) {
                e.preventDefault();
                var jobID = $(this).data('jobid');
                var jobDetails = $('#job-details-' + jobID);
                if (jobDetails.is(":visible")) {
                    jobDetails.hide();
                } else {
                    $(".job-details").hide();
                    jobDetails.show();
                }
            });
        });
    </script>
</body>
</html>
<?php } ?>
