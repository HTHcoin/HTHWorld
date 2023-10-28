<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
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

        <title>Admin Dashboard</title>

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
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="page-title">Dashboard</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $sql = "SELECT id from users";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $bg = $query->rowCount();
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Users</div>
                                                    </div>
                                                </div>
                                                <a href="userlist.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-success text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $reciver = 'Admin';
                                                        $sql1 = "SELECT id from feedback where reciver = (:reciver)";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->bindParam(':reciver', $reciver, PDO::PARAM_STR);
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $regbd = $query1->rowCount();
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($regbd); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Feedback</div>
                                                    </div>
                                                </div>
                                                <a href="feedback.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-danger text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $reciver = 'Admin';
                                                        $sql12 = "SELECT id from notification where notireciver = (:reciver)";
                                                        $query12 = $dbh->prepare($sql12);
                                                        $query12->bindParam(':reciver', $reciver, PDO::PARAM_STR);
                                                        $query12->execute();
                                                        $results12 = $query12->fetchAll(PDO::FETCH_OBJ);
                                                        $regbd2 = $query12->rowCount();
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($regbd2); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Notifications</div>
                                                    </div>
                                                </div>
                                                <a href="notification.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>

<!-- Add a new panel for Quests -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-info text-light">
            <div class="stat-panel text-center">
                <?php
                // Execute the SQL query to count the number of quests
                $questSql = "SELECT COUNT(id) as total FROM quests";
                $questQuery = $dbh->prepare($questSql);
                $questQuery->execute();
                $questCount = $questQuery->fetch(PDO::FETCH_ASSOC);
                $totalQuests = $questCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalQuests); ?></div>
                <div class="stat-panel-title text-uppercase">Quests</div>
            </div>
        </div>
        <a href="quests.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Quests Panel -->



<!-- Add a new panel for Volunteers -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-warning text-light">
            <div class="stat-panel text-center">
                <?php
                $volunteerSql = "SELECT COUNT(*) as total FROM volunteers";
                $volunteerQuery = $dbh->prepare($volunteerSql);
                $volunteerQuery->execute();
                $volunteerCount = $volunteerQuery->fetch(PDO::FETCH_ASSOC);
                $totalVolunteers = $volunteerCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalVolunteers); ?></div>
                <div class="stat-panel-title text-uppercase">Volunteers</div>
            </div>
        </div>
        <a href="volunteers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Volunteers Panel -->

<!-- Add a new panel for Homeless Individuals -->
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-info text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        // Execute the SQL query to count the number of registered homeless individuals
                                                        $homelessSql = "SELECT COUNT(id) as total FROM homeless_registration";
                                                        $homelessQuery = $dbh->prepare($homelessSql);
                                                        $homelessQuery->execute();
                                                        $homelessCount = $homelessQuery->fetch(PDO::FETCH_ASSOC);
                                                        $totalHomeless = $homelessCount['total'];
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($totalHomeless); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Homeless</div>
                                                    </div>
                                                </div>
                                                <a href="homelessList.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- End of Homeless Individuals Panel -->

<!-- Add a new panel for Sponsors -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-primary text-light">
            <div class="stat-panel text-center">
                <?php
                // Execute the SQL query to count the number of sponsors
                $sponsorsSql = "SELECT COUNT(id) as total FROM sponsorship";
                $sponsorsQuery = $dbh->prepare($sponsorsSql);
                $sponsorsQuery->execute();
                $sponsorsCount = $sponsorsQuery->fetch(PDO::FETCH_ASSOC);
                $totalSponsors = $sponsorsCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalSponsors); ?></div>
                <div class="stat-panel-title text-uppercase">Sponsors</div>
            </div>
        </div>
        <a href="sponsorList.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Sponsors Panel -->

                                        <!-- Add a new panel for Fundraisers -->
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-warning text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $fundraiserSql = "SELECT COUNT(id) as total FROM fundraisers";
                                                        $fundraiserQuery = $dbh->prepare($fundraiserSql);
                                                        $fundraiserQuery->execute();
                                                        $fundraiserCount = $fundraiserQuery->fetch(PDO::FETCH_ASSOC);
                                                        $totalFundraisers = $fundraiserCount['total'];
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($totalFundraisers); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Fundraisers</div>
                                                    </div>
                                                </div>
                                                <a href="fundraisers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- End of Fundraisers Panel -->

<!-- Add a new panel for Donations -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-info text-light">
            <div class="stat-panel text-center">
                <?php
                // Add your code to retrieve and display donation information
                // For example, you can count the number of donations from your database
                $donationSql = "SELECT COUNT(id) as total FROM donations";
                $donationQuery = $dbh->prepare($donationSql);
                $donationQuery->execute();
                $donationCount = $donationQuery->fetch(PDO::FETCH_ASSOC);
                $totalDonations = $donationCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalDonations); ?></div>
                <div class="stat-panel-title text-uppercase">Donations</div>
            </div>
        </div>
        <a href="donations.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Donations Panel -->

<!-- Add a new panel for Organizations -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-success text-light">
            <div class="stat-panel text-center">
                <?php
                // Execute the SQL query to count the number of organizations
                $organizationsSql = "SELECT COUNT(id) as total FROM outside_organizations";
                $organizationsQuery = $dbh->prepare($organizationsSql);
                $organizationsQuery->execute();
                $organizationsCount = $organizationsQuery->fetch(PDO::FETCH_ASSOC);
                $totalOrganizations = $organizationsCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalOrganizations); ?></div>
                <div class="stat-panel-title text-uppercase">Organizations</div>
            </div>
        </div>
        <a href="world_services.php?type=organization" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Organizations Panel -->

<!-- Add a new panel for Shelters -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-warning text-light">
            <div class="stat-panel text-center">
                <?php
                // Execute the SQL query to count the number of shelters
                $sheltersSql = "SELECT COUNT(id) as total FROM shelters";
                $sheltersQuery = $dbh->prepare($sheltersSql);
                $sheltersQuery->execute();
                $sheltersCount = $sheltersQuery->fetch(PDO::FETCH_ASSOC);
                $totalShelters = $sheltersCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalShelters); ?></div>
                <div class="stat-panel-title text-uppercase">Shelters</div>
            </div>
        </div>
        <a href="world_services.php?type=shelter" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Shelters Panel -->

<!-- Add a new panel for Food Banks -->
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body bk-info text-light">
            <div class "stat-panel text-center">
                <?php
                // Execute the SQL query to count the number of food banks
                $foodBanksSql = "SELECT COUNT(id) as total FROM food_banks";
                $foodBanksQuery = $dbh->prepare($foodBanksSql);
                $foodBanksQuery->execute();
                $foodBanksCount = $foodBanksQuery->fetch(PDO::FETCH_ASSOC);
                $totalFoodBanks = $foodBanksCount['total'];
                ?>
                <div class="stat-panel-number h1 "><?php echo htmlentities($totalFoodBanks); ?></div>
                <div class="stat-panel-title text-uppercase">Food Banks</div>
            </div>
        </div>
        <a href="world_services.php?type=food_bank" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
<!-- End of Food Banks Panel -->

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

        <script>
            window.onload = function () {
                // Line chart from swirlData for dashReport
                var ctx = document.getElementById("dashReport").getContext("2d");
                window.myLine = new Chart(ctx).Line(swirlData, {
                    responsive: true,
                    scaleShowVerticalLines: false,
                    scaleBeginAtZero: true,
                    multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
                });

                // Pie Chart from doughnutData
                var doctx = document.getElementById("chart-area3").getContext("2d");
                window.myDoughnut = new Chart(doctx).Pie(doughnutData, {
                    responsive: true
                });

                // Dougnut Chart from doughnutData
                var doctx = document.getElementById("chart-area4").getContext("2d");
                window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {
                    responsive: true
                });
            }
        </script>
    </body>
    </html>
<?php } ?>
