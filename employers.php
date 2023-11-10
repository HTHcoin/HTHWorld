<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php'); // Redirect to the login page if not logged in
} else {
    if (isset($_POST['submit'])) {
        if (isset($_SESSION['id'])) {
            // Retrieve data from the form
            $user_id = $_SESSION['id'];
            $company_name = $_POST['companyName'];
            $industry = $_POST['industry'];

            // Insert employer data into the database
            $sql = "INSERT INTO employers (user_id, company_name, industry) VALUES (:user_id, :company_name, :industry)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindParam(':company_name', $company_name, PDO::PARAM_STR);
            $query->bindParam(':industry', $industry, PDO::PARAM_STR);

            if ($query->execute()) {
                $_SESSION['msg'] = "Employer registered successfully.";
            } else {
                $_SESSION['error'] = "An error occurred. Please try again.";
            }
        } else {
            $_SESSION['error'] = "User ID not found in session.";
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
                    <h2 class="page-title">Register as an Employer</h2>
</br>
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
                                    <label class="col-sm-2 control-label">Company Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="companyName" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Industry</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="industry" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</br>
</br>

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
