<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php'); // Redirect to the login page if not logged in
} else {
    if (isset($_POST['submit'])) {
        if (isset($_SESSION['id'])) {
            // Retrieve data from the form
            $employer_id = $_SESSION['id'];
            $job_title = $_POST['jobTitle'];
            $job_description = $_POST['jobDescription'];
            $requirements = $_POST['requirements'];
            $location = $_POST['location'];
            $salary = $_POST['salary'];

            // Insert job data into the database
            $sql = "INSERT INTO jobs (employer_id, job_title, job_description, requirements, location, salary) VALUES (:employer_id, :job_title, :job_description, :requirements, :location, :salary)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':employer_id', $employer_id, PDO::PARAM_INT);
            $query->bindParam(':job_title', $job_title, PDO::PARAM_STR);
            $query->bindParam(':job_description', $job_description, PDO::PARAM_STR);
            $query->bindParam(':requirements', $requirements, PDO::PARAM_STR);
            $query->bindParam(':location', $location, PDO::PARAM_STR);
            $query->bindParam(':salary', $salary, PDO::PARAM_STR);

            if ($query->execute()) {
                $_SESSION['msg'] = "Job created successfully.";
            } else {
                $_SESSION['error'] = "An error occurred. Please try again.";
            }
        } else {
            $_SESSION['error'] = "Employer ID not found in session.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>User Dashboard</title>

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

    .panel-body {
        background-color: #333;
    }

    .form-horizontal .form-group {
        margin-bottom: 15px;
    }

    .form-horizontal .control-label {
        text-align: right;
        margin-top: 8px;
    }

    .form-horizontal .form-control {
        width: 100%;
    }

    .form-horizontal .btn-primary {
        background-color: #333;
        border-color: #333;
    }

    .form-horizontal .btn-primary:hover {
        background-color: #444;
        border-color: #444;
    }

    .alert {
        margin-bottom: 15px;
    }

    .create-button {
        display: inline-block;
        background-color: #34bcaa;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        margin: 10px;
        box-shadow: 0 0 10px #debf12;
    }

    .create-button:hover {
        background-color: #debf12;
        box-shadow: 0 0 10px #34bcaa;
    }

</style>

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
                    <h2 class="page-title">Create a Job</h2>
                    <?php
                    // Display success or error messages
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }

                    if (isset($_SESSION['msg'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Job Title</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="jobTitle" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Job Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="jobDescription" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Requirements</label>
                                    <div class="col-sm-8">
                                        <textarea name="requirements" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Location</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="location" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Salary</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="salary" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" name="submit" class="create-button">Create Job</button>
                                    </div>
                                </div>
                            </form>
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
