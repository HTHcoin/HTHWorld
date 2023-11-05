<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

$msg = ''; // Initialize $msg

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $user_id = $_SESSION['id']; // Get the logged-in user's ID

    if (isset($_GET['apply'])) {
        $jobId = $_GET['apply'];
    } else {
        // Redirect or display an error message if no job ID is provided
        header('location:index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_SESSION['id'];
        $coverLetter = $_POST['coverLetter']; // Get the cover letter from the form
        $skills = $_POST['skills']; // Get skills from the form
        $resume = $_POST['resume']; // Get experience from the form

        // Insert the application into the 'job_applications' table
        $sql = "INSERT INTO job_applications (job_id, user_id, cover_letter, skills, resume) VALUES (:jobId, :user_id, :coverLetter, :skills, :resume)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':jobId', $jobId, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':coverLetter', $coverLetter, PDO::PARAM_STR);
        $query->bindParam(':skills', $skills, PDO::PARAM_STR);
        $query->bindParam(':resume', $resume, PDO::PARAM_STR);
        $query->execute();

        $msg = "Job application submitted successfully";
    }

    // Fetch job details for the given job ID
    $sql = "SELECT * FROM jobs WHERE id = :jobId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':jobId', $jobId, PDO::PARAM_INT);
    $query->execute();
    $jobDetails = $query->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- Include your meta tags, title, and styles here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Job Application</title>

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
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Job Application for: <?php echo htmlentities($jobDetails->job_title); ?></h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if ($msg) { ?>
                                    <div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?></div>
                                <?php } ?>

                                <!-- Job application form -->
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Cover Letter</label>
                                        <textarea name="coverLetter" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Skills</label>
                                        <input type="text" name="skills" class="form-control" required>
                                    </div>
                                   <div class="form-group">
    <label>Resume</label>
    <textarea name="resume" class="form-control" required></textarea>
</div>
                                    <button type="submit" class="btn btn-primary">Submit Application</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include your JavaScript files here -->
</body>
</html>
