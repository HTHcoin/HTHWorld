<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:login.php');
} else {
    if (isset($_POST['complete_quest'])) {
        $questId = $_POST['quest_id'];
        $userId = $_SESSION['id'];

        // Check if the user has already completed the quest
        $checkQuery = "SELECT * FROM user_quests WHERE user_id = :userId AND quest_id = :questId";
        $checkStatement = $dbh->prepare($checkQuery);
        $checkStatement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $checkStatement->bindParam(':questId', $questId, PDO::PARAM_INT);
        $checkStatement->execute();

        if ($checkStatement->rowCount() == 0) {
            // User hasn't completed the quest, so mark it as completed
            $insertQuery = "INSERT INTO user_quests (user_id, quest_id) VALUES (:userId, :questId)";
            $insertStatement = $dbh->prepare($insertQuery);
            $insertStatement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $insertStatement->bindParam(':questId', $questId, PDO::PARAM_INT);
            $insertStatement->execute();

            // Award XP rewards based on the quest's XP reward
            $questInfoQuery = "SELECT xp_reward FROM quests WHERE id = :questId";
            $questInfoStatement = $dbh->prepare($questInfoQuery);
            $questInfoStatement->bindParam(':questId', $questId, PDO::PARAM_INT);
            $questInfoStatement->execute();
            $questInfo = $questInfoStatement->fetch(PDO::FETCH_ASSOC);
            $xpReward = $questInfo['xp_reward'];

            // Update the user's XP
            $updateXPQuery = "UPDATE users SET xp_reward = xp_reward + :xpReward WHERE id = :userId";
            $updateXPStatement = $dbh->prepare($updateXPQuery);
            $updateXPStatement->bindParam(':xpReward', $xpReward, PDO::PARAM_INT);
            $updateXPStatement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $updateXPStatement->execute();

            $response = array(
                'status' => 'success',
                'message' => "Quest completed successfully! You have earned " . $xpReward . " XP."
            );
            echo json_encode($response);
            exit;
        } else {
            $response = array(
                'status' => 'error',
                'message' => "You have already completed this quest."
            );
            echo json_encode($response);
            exit;
        }
    }

    // Fetch available quests
    $quests = array();
    $questMsg = ""; // Message to display quests

    $questSql = "SELECT * FROM quests";
    $questQuery = $dbh->prepare($questSql);
    $questQuery->execute();

    while ($quest = $questQuery->fetch(PDO::FETCH_ASSOC)) {
        $quests[] = $quest;
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Quests</title>

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
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

</script>
	<style>
	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

h4 {
text-align: center;
color: #debf12;
}

th {
text-align: center;
color: #34bcaa;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
    color: #debf12;
}
		</style>


</head>

<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">User Quests</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($quests)) : ?>
                                    <h4>Available Quests</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Quest Name</th>
                                                <th>Description</th>
                                                <th>XP Reward</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($quests as $quest) : ?>
                                                <tr>
                                                    <td><?php echo $quest['name']; ?></td>
                                                    <td><?php echo $quest['description']; ?></td>
                                                    <td><?php echo $quest['xp_reward']; ?></td>
                                                    <td>
                                                        <form class="quest-form">
                                                            <input type="hidden" name="quest_id" value="<?php echo $quest['id']; ?>">
                                                            <button type="button" class="complete-quest">Complete Quest</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No quests available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.complete-quest').click(function() {
                var form = $(this).closest('.quest-form');
                var questId = form.find('input[name="quest_id"]').val();

                $.ajax({
                    type: 'POST',
                    url: 'userQuests.php', // Change this URL if necessary
                    data: { complete_quest: true, quest_id: questId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Quest completed successfully, show the message
                            alert(response.message);
                            // You can also update the XP on the page without reloading
                            // Add code to update the XP here
                        } else {
                            // Quest completion failed, show the message
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>