<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Fetch data based on the selected service type
$selectedServiceType = $_GET['service_type'] ?? 'shelter'; // Default to 'shelter'

// Initialize an empty array to store service data
$serviceData = array();

try {
    // Define your SQL query to fetch service data from the corresponding table
    $serviceTable = ''; // Define the variable to hold the table name based on the selectedServiceType

    switch ($selectedServiceType) {
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

    if (!empty($serviceTable)) {
        $serviceSql = "SELECT * FROM $serviceTable";
        $serviceQuery = $dbh->prepare($serviceSql);
        $serviceQuery->execute();

        while ($service = $serviceQuery->fetch(PDO::FETCH_ASSOC)) {
            $serviceData[] = $service;
        }
    }
} catch (PDOException $e) {
    // Handle database-related errors when fetching service data
    $serviceErrorMsg = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTH World Services</title>
    <link rel="stylesheet" href="css/style.css">
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #debf12;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .about-container {
            text-align: center;
            background-color: #333;
            padding: 20px;
            box-shadow: 0 0 10px #34bcaa;
            margin-right: 5%;
            margin-left: 5%;
            border-radius: 15px;
        }

        .about-container h2 {
            font-size: 24px;
            color: #34bcaa;
        }

        .about-container p {
            font-size: 16px;
            color: #fff;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select option {
            font-size: 16px;
            background-color: #fff;
            color: #333;
        }

        select option:hover {
            background-color: #ddd;
        }
    .service-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .service-card {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        background-color: #333;
        width: calc(33.33% - 20px);
    }

    .service-card h3 {
        font-size: 24px;
        color: #debf12;
    }

    .service-card p {
        font-size: 16px;
        color: #fff;
    }
    </style>
</head>
<body style="background-color: #333">
    <header>
        <h1>Welcome to HTH World</h1>
        <p style="color: #debf12">Helping the Community Together</p>
    </header>
    <?php
    // Include the navigation bar
    include('navbar.php');
    ?>
</br>
</br>
        <div class="about-container">
    <h1>HTH Services</h1>

       <!-- Display entries for the selected service type -->
        <h2>Resources</h2>
        <select onchange="location = this.value;">
            <option value="world.php?service_type=shelter" <?php if ($selectedServiceType === 'shelter') echo 'selected'; ?>>Shelters</option>
            <option value="world.php?service_type=food_bank" <?php if ($selectedServiceType === 'food_bank') echo 'selected'; ?>>Food Banks</option>
            <option value="world.php?service_type=organization" <?php if ($selectedServiceType === 'organization') echo 'selected'; ?>>Organizations</option>
        </select>

<?php if (!empty($serviceData)) : ?>
    <div class="service-cards">
        <?php foreach ($serviceData as $service) : ?>
            <div class="service-card">
                <h3><?php echo $service['name']; ?></h3>
                <p><strong>Address:</strong> <?php echo $service['address']; ?></p>
                <p><strong>Contact Email:</strong> <?php echo $service['contact_email']; ?></p>
                <p><strong>Contact Phone:</strong> <?php echo $service['contact_phone']; ?></p>
                <p><strong>Services:</strong> <?php echo $service['services']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>No entries found.</p>
<?php endif; ?>
    </div>
</br>
    <?php
    // Include the footer
    include('footer.php');
    ?>
</body>
</html>
