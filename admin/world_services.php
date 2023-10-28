<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in as an admin (You may need to adjust this part)
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
}

// Handle form submissions for creating new entries
if (isset($_POST['submit'])) {
    $serviceType = $_POST['service_type'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contactEmail = $_POST['contact_email'];
    $contactPhone = $_POST['contact_phone'];
    $services = $_POST['services'];

    // Insert data into the selected service table
    switch ($serviceType) {
        case 'shelter':
            $sql = "INSERT INTO shelters (shelter_name, address, contact_email, contact_phone, services) 
                    VALUES (:name, :address, :contactEmail, :contactPhone, :services)";
            break;
        case 'food_bank':
            $sql = "INSERT INTO food_banks (name, address, contact_email, contact_phone, services) 
                    VALUES (:name, :address, :contactEmail, :contactPhone, :services)";
            break;
        case 'organization':
            $sql = "INSERT INTO outside_organizations (name, address, contact_email, contact_phone, services) 
                    VALUES (:name, :address, :contactEmail, :contactPhone, :services)";
            break;
    }

    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name);
    $query->bindParam(':address', $address);
    $query->bindParam(':contactEmail', $contactEmail);
    $query->bindParam(':contactPhone', $contactPhone);
    $query->bindParam(':services', $services);

    if ($query->execute()) {
        $successMsg = "Entry added successfully.";
    } else {
        $errorMsg = "Error adding entry.";
    }
}

// Fetch services for display based on the selected type
$selectedType = $_GET['type'] ?? 'shelter'; // Default to shelter
$services = array();

switch ($selectedType) {
    case 'shelter':
        $serviceTable = 'shelters';
        break;
    case 'food_bank':
        $serviceTable = 'food_banks';
        break;
    case 'organization':
        $serviceTable = 'outside_organizations';
        break;
}

if (isset($serviceTable)) {
    $fetchSql = "SELECT * FROM $serviceTable";
    $fetchQuery = $dbh->prepare($fetchSql);
    $fetchQuery->execute();

    while ($service = $fetchQuery->fetch(PDO::FETCH_ASSOC)) {
        $services[] = $service;
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Manage HTH Services</title>

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
    <link rel="stylesheet" href="css/world.css">
    <script type="text/javascript" src="../vendor/countries.js"></script>
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
    <?php include('navbar.php'); ?> <!-- Include your website's navigation bar or header -->
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
    </div>
</br>
</br>
    <div class="container">
        <h1>World Services</h1>

        <!-- Form to add new entries -->
        <h2>Add a New Entry</h2>
        <form method="post" action="world_services.php">
            <select name="service_type">
                <option value="shelter">Shelter</option>
                <option value="food_bank">Food Bank</option>
                <option value="organization">Organization</option>
            </select>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="contact_email" placeholder="Contact Email">
            <input type="text" name="contact_phone" placeholder="Contact Phone">
            <textarea name="services" placeholder="Services"></textarea>
            <input type="submit" name="submit" value="Add Entry">
        </form>

        <?php if (isset($successMsg)) : ?>
            <div class="success-message"><?php echo $successMsg; ?></div>
        <?php elseif (isset($errorMsg)) : ?>
            <div class="error-message"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <!-- Display entries for the selected service type -->
        <h2>Display Entries</h2>
        <select onchange="location = this.value;">
            <option value="world_services.php?type=shelter" <?php if ($selectedType === 'shelter') echo 'selected'; ?>>Shelters</option>
            <option value="world_services.php?type=food_bank" <?php if ($selectedType === 'food_bank') echo 'selected'; ?>>Food Banks</option>
            <option value="world_services.php?type=organization" <?php if ($selectedType === 'organization') echo 'selected'; ?>>Organizations</option>
        </select>

        <?php if (!empty($services)) : ?>
            <ul>
                <?php foreach ($services as $service) : ?>
                    <li>
                        <h3><?php echo $service['name']; ?></h3>
                        <p>Address: <?php echo $service['address']; ?></p>
                        <p>Contact Email: <?php echo $service['contact_email']; ?></p>
                        <p>Contact Phone: <?php echo $service['contact_phone']; ?></p>
                        <p>Services: <?php echo $service['services']; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No entries found.</p>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?> <!-- Include your website's footer -->
</body>
</html>
