<?php
// Include your database connection or config file
include('includes/config.php');

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Query the database to get the user's profile information
    $sql = "SELECT * FROM users WHERE id = :userId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Display the user's profile information
    if ($user) {
        echo '<h3>' . $user['name'] . '</h3>';
        echo '<p>Email: ' . $user['email'] . '</p>';
        echo '<p>Designation: ' . $user['designation'] . '</p>';
        echo '<img src="images/' . $user['image'] . '" alt="User Image" style="max-width: 200px;">';
    } else {
        echo 'User not found';
    }
} else {
    echo 'Invalid request';
}
?>
