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
    <!-- Add your meta tags and stylesheets as per your template -->
</head>

<body>
    <!-- Include your header and sidebar here as per your template -->

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
                                        <button type="submit" name="submit" class="btn btn-primary">Create Job</button>
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
