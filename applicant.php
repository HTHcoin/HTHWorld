<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['accept_application'])) {
            $applicationId = $_POST['application_id'];
            // Handle "Accept" action for the selected application
            $sql = "UPDATE job_applications SET application_status = 'Accepted' WHERE id = :applicationId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':applicationId', $applicationId, PDO::PARAM_INT);

            if ($query->execute()) {
                // Application accepted successfully.
                echo "Application accepted successfully.";
            } else {
                echo "Error accepting application: " . implode(" - ", $query->errorInfo());
            }
        } elseif (isset($_POST['deny_application'])) {
            $applicationId = $_POST['application_id'];
            // Handle "Deny" action for the selected application
            $sql = "UPDATE job_applications SET application_status = 'Denied' WHERE id = :applicationId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':applicationId', $applicationId, PDO::PARAM_INT);
            if ($query->execute()) {
                echo "Application denied successfully.";
            } else {
                echo "Error denying application: " . implode(" - ", $query->errorInfo());
            }
        }
    }

    // Fetch job applications for the logged-in user
    $user_id = $_SESSION['id']; // Get the logged-in user's ID
    $sql = "SELECT job_applications.*, jobs.job_title FROM job_applications
        JOIN jobs ON job_applications.job_id = jobs.id
        WHERE job_applications.user_id = :user_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($query->execute()) {
        $applications = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Error fetching job applications: " . implode(" - ", $query->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- Include your meta tags, title, and styles here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Job Applications</title>

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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
.brand .menu-btn {
    float: right;
    background: #232d3b;
    text-align: center;
    cursor: pointer;
    color: #fff;
    padding: 20px 20px;
}

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
                        <h2 class="page-title">Job Applications</h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if (!empty($applications)) { ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Cover Letter</th>
                                                <th>Skills</th>
                                                <th>Resume</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($applications as $application) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($application['job_title']); ?></td>
                                                    <td><?php echo htmlentities($application['cover_letter']); ?></td>
                                                    <td><?php echo htmlentities($application['skills']); ?></td>
                                                    <td><?php echo htmlentities($application['resume']); ?></td>
                                                    <td><?php echo isset($application['application_status']) ? htmlentities($application['application_status']) : 'Pending'; ?></td>
                                                    <td>
                                                        <form method="post" action="">
                                                            <input type="hidden" name="application_id" value="<?php echo $application['id']; ?>">
                                                            <button type="submit" name="accept_application">Accept</button>
                                                            <button type="submit" name="deny_application">Deny</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else {
                                    echo "You have not submitted any job applications.";
                                } ?>
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
