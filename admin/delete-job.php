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

        $sql = "DELETE FROM jobs WHERE id = :job_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        $query->execute();

        $msg = "Job deleted successfully";
    } else {
        header("location:employersList.php");
    }
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv X-UA-Compatible content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Delete Job</title>

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
                        <h2 class="page-title">Delete Job</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Delete Job</div>
                            <div class="panel-body">
                                <?php if ($msg) { ?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php } ?>
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
