<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['job_id']) && isset($_GET['user_id'])) {
        $job_id = $_GET['job_id'];
        $user_id = $_GET['user_id'];
    } else {
        header("location:employersList.php");
    }

    if (isset($_POST['submit'])) {
        $jobTitle = $_POST['jobTitle'];
        $jobDescription = $_POST['jobDescription'];

        $sql = "UPDATE jobs SET job_title = :jobTitle, job_description = :jobDescription WHERE id = :job_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':jobTitle', $jobTitle, PDO::PARAM_STR);
        $query->bindParam(':jobDescription', $jobDescription, PDO::PARAM_STR);
        $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        $query->execute();

        $msg = "Job details updated successfully";
    }

    $sql = "SELECT * FROM jobs WHERE id = :job_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $query->execute();
    $job = $query->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Edit Job</title>

    <!-- Include your CSS and JavaScript files here -->

</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Job</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Job</div>
                            <div class="panel-body">
                                <?php if ($msg) { ?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php } ?>
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Job Title</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="jobTitle" value="<?php echo htmlentities($job['job_title']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Job Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="jobDescription" required><?php echo htmlentities($job['job_description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-4">
                                            <button class="btn btn-primary" type="submit" name="submit">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>
