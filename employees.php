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
    <title>Employee Registration</title>
    <!-- Include your CSS and JavaScript dependencies here -->
</head>
<body>
    <h1>Employee Registration</h1>
    
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
</body>
</html>
