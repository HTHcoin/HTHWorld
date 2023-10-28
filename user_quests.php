<?php
session_start();
error_reporting(0);
include('includes/config.php'); // Include your database configuration

if (strlen($_SESSION['alogin']) > 0) {
    header('location: login.php'); // Redirect users if they are not logged in
} else {
    if (isset($_POST['complete_quest'])) {
        $questId = $_POST['quest_id'];
        $userId = $_SESSION['id'];

        // Check if the user has already completed the quest
        $checkQuery = "SELECT * FROM user_quest WHERE user_id = :userId AND quest_id = :questId";
        $checkStatement = $dbh->prepare($checkQuery);
        $checkStatement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $checkStatement->bindParam(':questId', $questId, PDO::PARAM_INT);
        $checkStatement->execute();

        if ($checkStatement->rowCount() == 0) {
            // User hasn't completed the quest, so mark it as completed
            $insertQuery = "INSERT INTO user_quest (user_id, quest_id) VALUES (:userId, :questId)";
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
            $updateXPQuery = "UPDATE users SET xp = xp + :xpReward WHERE id = :userId";
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
}
?>
