<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['create_quest'])) {
        $quest_name = $_POST['quest_name'];
        $description = $_POST['description'];
        $xp_reward = $_POST['xp_reward'];

        $insertQuery = "INSERT INTO quests (name, description, xp_reward) VALUES (:quest_name, :description, :xp_reward)";

        $insertStatement = $dbh->prepare($insertQuery);
        $insertStatement->bindParam(':quest_name', $quest_name, PDO::PARAM_STR);
        $insertStatement->bindParam(':description', $description, PDO::PARAM_STR);
        $insertStatement->bindParam(':xp_reward', $xp_reward, PDO::PARAM_INT);
        $insertStatement->execute();
    }

    // Fetch quests
    $quests = array();
    $questMsg = "";  // Message to display quests

    $questSql = "SELECT * FROM quests";
    $questQuery = $dbh->prepare($questSql);
    $questQuery->execute();

    while ($quest = $questQuery->fetch(PDO::FETCH_ASSOC)) {
        $quests[] = $quest;
    }

    if (isset($_POST['edit_quest'])) {
        $quest_id = $_POST['quest_id'];

        // Fetch quest details based on $quest_id
        $editQuestSql = "SELECT * FROM quests WHERE id = :quest_id";
        $editQuestQuery = $dbh->prepare($editQuestSql);
        $editQuestQuery->bindParam(':quest_id', $quest_id, PDO::PARAM_INT);
        $editQuestQuery->execute();
        $editQuest = $editQuestQuery->fetch(PDO::FETCH_ASSOC);
    }

    if (isset($_POST['update_quest'])) {
        $quest_id = $_POST['quest_id'];
        $quest_name = $_POST['quest_name'];
        $description = $_POST['description'];
        $xp_reward = $_POST['xp_reward'];

        // Update the quest details in the database
        $updateQuestSql = "UPDATE quests SET name = :quest_name, description = :description, xp_reward = :xp_reward WHERE id = :quest_id";
        $updateQuestQuery = $dbh->prepare($updateQuestSql);
        $updateQuestQuery->bindParam(':quest_name', $quest_name, PDO::PARAM_STR);
        $updateQuestQuery->bindParam(':description', $description, PDO::PARAM_STR);
        $updateQuestQuery->bindParam(':xp_reward', $xp_reward, PDO::PARAM_INT);
        $updateQuestQuery->bindParam(':quest_id', $quest_id, PDO::PARAM_INT);
        $updateQuestQuery->execute();
    }

    if (isset($_POST['delete_quest'])) {
        $quest_id = $_POST['quest_id'];

        // Delete the quest from the database
        $deleteQuestSql = "DELETE FROM quests WHERE id = :quest_id";
        $deleteQuestQuery = $dbh->prepare($deleteQuestSql);
        $deleteQuestQuery->bindParam(':quest_id', $quest_id, PDO::PARAM_INT);
        $deleteQuestQuery->execute();
    }
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Quest Management</title>

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
    <link rel="stylesheet" href="css/fundraisers.css">
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
    <?php
    $sql = "SELECT * from admin;";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $cnt = 1;
    ?>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Manage Quests</h3>
                        <div class="row">
                            <!-- "Menu Form" -->
                            <div class="col-md-15">
                                <h4>Create New Quest</h4>
                                <form method="post">
                                    <label for="quest_name">Quest Name</label>
                                    <input type="text" name="quest_name" required>

                                    <label for="description">Description</label>
                                    <input type="text" name="description" required>

                                    <label for="xp_reward">XP Reward</label>
                                    <input type="number" name="xp_reward" required>

                                    <button type="submit" name="create_quest">Create Quest</button>
                                </form>
                            </div>
                        </div>
                        </br>
                        </br>
                        <!-- "Quests List" -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($quests)) : ?>
                                    <h4>Quests List</h4>
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
    <form method="post" style="display: inline;">
        <input type="hidden" name="quest_id" value="<?php echo $quest['id']; ?>">
        <button type="submit" name="delete_quest">Delete</button>
    </form>
</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No quests found.</p>
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
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(function () {
                $('.succWrap').slideUp("slow");
            }, 3000);
        });
    </script>
</body>
</html>
<?php } ?>
