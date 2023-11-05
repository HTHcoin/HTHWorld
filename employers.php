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
    <!-- Add your meta tags and stylesheets as per your template -->
</head>

<body>
    <!-- Include your header and sidebar here as per your template -->

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Register as an Employer</h2>
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
</body>
</html>
