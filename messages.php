<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in; if not, redirect to the login page
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Handle sending and displaying messages here
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $recipientEmail = $_POST['recipient_email'];
        $message = $_POST['message'];

        // Validate and sanitize user input
        $recipientEmail = htmlspecialchars($recipientEmail);
        $message = htmlspecialchars($message);

        // Get the user's ID based on the recipient's email
        $recipientQuery = "SELECT id FROM users WHERE email = :recipientEmail";
        $recipientResult = $dbh->prepare($recipientQuery);
        $recipientResult->bindParam(':recipientEmail', $recipientEmail);
        $recipientResult->execute();

        if ($recipientResult) {
            $recipientData = $recipientResult->fetch(PDO::FETCH_ASSOC);
            if ($recipientData) {
                $recipientId = $recipientData['id'];

                // Get the sender's ID from the session
                $senderId = $_SESSION['alogin'];

                // Insert the message into the database
                $insertQuery = "INSERT INTO messages (sender, recipient, message, message_type) 
                    VALUES (:senderId, :recipientId, :message, 'text')";

                $insertResult = $dbh->prepare($insertQuery);
                $insertResult->bindParam(':senderId', $senderId);
                $insertResult->bindParam(':recipientId', $recipientId);
                $insertResult->bindParam(':message', $message);

                if ($insertResult->execute()) {
                    echo '<div class="succWrap">Message sent successfully.</div>';
                } else {
                    echo '<div class="errorWrap">Error sending the message.</div>';
                }
            } else {
                echo '<div class="errorWrap">Recipient not found.</div>';
            }
        }
    }

    // Display messages
    // Your SQL query to fetch messages should join the users' table to get sender and recipient names
    $senderId = $_SESSION['user_id']; // Assuming 'user_id' is the key for the user's ID in the session
    $messageQuery = "SELECT m.*, u1.name as sender_name, u2.name as recipient_name
                    FROM messages m
                    JOIN users u1 ON m.sender = u1.id
                    JOIN users u2 ON m.recipient = u2.id
                    WHERE m.sender = :senderId OR m.recipient = :senderId";
    $messageResult = $dbh->prepare($messageQuery);
    $messageResult->bindParam(':senderId', $senderId);
    $messageResult->execute();
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
    
    <title>Messages</title>

    <!-- Add necessary CSS and JavaScript libraries here -->
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
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Messages</h2>

                        <!-- Create the messaging interface here -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Messaging</div>
                            <div class="panel-body">
                                <!-- Display messages here -->
                                <div class="messages-container">
                                    <?php
                                    while ($row = $messageResult->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['sender'] == $senderId) {
                                            echo '<div class="outgoing-message">' . $row['message'] . '</div>';
                                        } else {
                                            echo '<div class="incoming-message">' . $row['sender_name'] . ': ' . $row['message'] . '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Create a form for sending messages -->
<form method="post" action="messages.php">
    <input type="text" name="recipient_email" placeholder="Recipient's Email" required>
    <textarea name="message" placeholder="Your message" required></textarea>
    <button type="submit">Send</button>
</form>
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
                $('.succWrap').slideUp('slow');
            }, 3000);
        });
    </script>
</body>
</html>