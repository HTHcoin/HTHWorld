<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Fetch fundraisers
$fundraisers = array();

try {
    $fundraiserSql = "SELECT * FROM fundraisers";
    $fundraiserQuery = $dbh->prepare($fundraiserSql);
    $fundraiserQuery->execute();

    while ($fundraiser = $fundraiserQuery->fetch(PDO::FETCH_ASSOC)) {
        $fundraisers[] = $fundraiser;
    }
} catch (PDOException $e) {
    // Handle database-related errors when fetching fundraisers
    $fundraiserMsg = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraisers</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Adjust the path to your CSS file -->
</head>
<body>
    <header>
        <h1>Welcome to HTH World</h1>
        <p>Helping the Community Together</p>
    </header>
    <?php include('navbar.php'); ?> <!-- Include your website's navigation bar or header -->

    <div class="container">
        <h1>Current Fundraisers</h1>

        <?php if (!empty($fundraiserMsg)) : ?>
            <div class="error-message"><?php echo $fundraiserMsg; ?></div>
        <?php endif; ?>

        <div class="fundraiser-list">
    <ul>
        <?php foreach ($fundraisers as $fundraiser) : ?>
            <li>
                <h3><?php echo $fundraiser['campaign_name']; ?></h3>
                <p>Organizer: <?php echo $fundraiser['organizer']; ?></p>
                <p>Start Date: <?php echo $fundraiser['start_date']; ?></p>
                <p>End Date: <?php echo $fundraiser['end_date']; ?></p>
                <p>Goal Amount: $<?php echo $fundraiser['goal_amount']; ?></p>
                <p>Progress: <?php echo $fundraiser['progress']; ?>%</p>
                <a href="donate.php?fundraiser_id=<?php echo $fundraiser['id']; ?>">Donate</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
    </div>
</br>
</br>
    <?php include('footer.php'); ?> <!-- Include your website's footer -->
</body>
</html>
