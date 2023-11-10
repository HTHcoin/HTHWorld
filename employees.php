<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $user_id = $_SESSION['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_employee'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $mobile = $_POST['mobile'];
        $designation = $_POST['designation'];

        // Insert employee information into the database
        $sql = "INSERT INTO employees (user_id, employee_name, email, gender, mobile, position)
        VALUES (:user_id, :name, :email, :gender, :mobile, :designation)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':designation', $designation, PDO::PARAM_STR);

        $query->execute();

        // Redirect to the employee dashboard upon successful registration
        header('location:employees-landing.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Employee Registration</title>

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
    body {
        background-color: #333;
        color: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #debf12;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #444;
        border-radius: 5px;
        box-shadow: 0 0 5px #34bcaa;
    }

    label {
        display: block;
        margin-top: 10px;
        color: #34bcaa !important;

    input[type="text"],
    input[type="email"],
    input[type="radio"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: none;
        background-color: #fff;
        color: #000;
        border-radius: 3px;
    }

    input[type="radio"] {
        display: inline;
        margin-right: 10px;
    }

    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #444;
    }
</style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
</br>
</br>
</br>
    <h1>Employee Registration</h1>
</br>
</br>
    <!-- Employee Registration Form -->
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="gender">Gender:</label>
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female
        
        <label for="mobile">Mobile:</label>
        <input type="text" name="mobile" required>
        
        <label for="designation">Designation:</label>
        <input type="text" name="designation" required>
        
        <button type="submit" name="register_employee">Register</button>
    </form>
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
