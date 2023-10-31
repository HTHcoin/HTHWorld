<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:login.php');
} else {
    $email = $_SESSION['alogin'];

    // Fetch user's information
    $userSql = "SELECT * FROM users WHERE email = (:email)";
    $userQuery = $dbh->prepare($userSql);
    $userQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $userQuery->execute();
    $userResult = $userQuery->fetch(PDO::FETCH_OBJ);

    // Fetch user's total XP reward from quests
    $xpTotalSql = "SELECT SUM(q.xp_reward) AS total_xp_reward
                  FROM users u
                  INNER JOIN user_quests uq ON u.id = uq.user_id
                  INNER JOIN quests q ON uq.quest_id = q.id
                  WHERE u.id = :userId";
    $xpTotalQuery = $dbh->prepare($xpTotalSql);
    $xpTotalQuery->bindParam(':userId', $userResult->id, PDO::PARAM_INT);
    $xpTotalQuery->execute();
    $xpTotalResult = $xpTotalQuery->fetch(PDO::FETCH_OBJ);

    // Fetch user's XP reward from quests
    $xpSql = "SELECT q.name AS quest_name, SUM(q.xp_reward) AS xp_reward
              FROM users u
              INNER JOIN user_quests uq ON u.id = uq.user_id
              INNER JOIN quests q ON uq.quest_id = q.id
              WHERE u.id = :userId
              GROUP BY q.name";
    $xpQuery = $dbh->prepare($xpSql);
    $xpQuery->bindParam(':userId', $userResult->id, PDO::PARAM_INT);
    $xpQuery->execute();
    $xpResults = $xpQuery->fetchAll(PDO::FETCH_OBJ);
    
    $cnt = 1;
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>User Dashboard</title>

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
    <link rel="stylesheet" href="css/homepage.css">
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

/* Style for the balance and wallet address */
#walletAddress,
#balance {
    font-weight: bold;
    color: #333;
}
/* Style for the buttons */
button {
    display: block;
    margin: 10px auto;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12"> <!-- Apply the left-section class here -->
                                <div class="form-group">
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <img src="images/<?php echo htmlentities($userResult->image); ?>" style="width:200px; border-radius:50%; margin:10px;">
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <h3>Welcome, <?php echo htmlentities($userResult->name); ?><span style="color: red;"> (<?php echo htmlentities($userResult->designation); ?>)</span></h3>
                <!-- Display user's wallet address and balance -->
                    <h1>Ethereum Wallet Interaction</h1>
    <button id="connectWallet">Connect to Wallet</button>
    <button id="disconnectWallet" style="display: none;">Disconnect Wallet</button>
    <div id="walletInfo" style="display: none;">
        <p>Wallet Address: <span id="walletAddress"></span></p>
        <p>Balance: <span id="balance"></span> ETH</p>
    </div>
                                                <p>Your Total XP: <?php echo htmlentities($xpTotalResult->total_xp_reward); ?></p>
                                                    <?php if ($userResult->designation === 'Sponsor') : ?>
                                                        <p>Sponsor</p>
                                                        <div class="quest-list"> <!-- Apply the quest-list class here -->
                                                            <h4>Your Sponsored Homeless Persons:</h4>
                                                            <?php
                                                            // Fetch the list of homeless persons sponsored by this user
                                                            $sponsorshipSql = "SELECT h.name AS homeless_name
                                                                              FROM sponsorship s
                                                                              INNER JOIN homeless_registration h ON s.homeless_person_id = h.id
                                                                              WHERE s.sponsor_id = :sponsor_id";
                                                            $sponsorshipQuery = $dbh->prepare($sponsorshipSql);
                                                            $sponsorshipQuery->bindParam(':sponsor_id', $userResult->id, PDO::PARAM_INT);
                                                            $sponsorshipQuery->execute();
                                                            $sponsoredHomelessPersons = $sponsorshipQuery->fetchAll(PDO::FETCH_OBJ);

                                                            if (!empty($sponsoredHomelessPersons)) {
                                                                echo '<ul>';
                                                                foreach ($sponsoredHomelessPersons as $homelessPerson) {
                                                                    echo '<li>' . htmlentities($homelessPerson->homeless_name) . '</li>';
                                                                }
                                                                echo '</ul>';
                                                            } else {
                                                                echo '<p>You have not sponsored any homeless persons yet.</p>';
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 left-section">
                                <div class="quest-list"> <!-- Apply the quest-list class here -->
                                    <!-- Display completed quests and their XP rewards -->
                                    <?php if (!empty($xpResults)) : ?>
                                        <h4>Completed Quests:</h4>
                                        <ul>
                                            <?php foreach ($xpResults as $quest) : ?>
                                                <li><?php echo htmlentities($quest->quest_name); ?>: <?php echo htmlentities($quest->xp_reward); ?> XP</li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p>No quests completed yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div> <!-- Clear the float to prevent layout issues -->
    </div>

    <!-- Include the JavaScript code for wallet interaction (already provided) -->
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let web3;
        let connected = false;

        async function connectWallet() {
            if (typeof window.ethereum !== 'undefined') {
                web3 = new Web3(window.ethereum);
                try {
                    if (!connected) {
                        await window.ethereum.request({ method: 'eth_requestAccounts' });
                        connected = true;
                        document.getElementById('connectWallet').style.display = 'none';
                        document.getElementById('disconnectWallet').style.display = 'block';
                    }
                    const accounts = await web3.eth.getAccounts();
                    if (accounts.length > 0) {
                        const walletAddress = accounts[0];
                        document.getElementById('walletAddress').textContent = walletAddress;
                        document.getElementById('walletInfo').style.display = 'block';
                        getBalance(walletAddress);
                    } else {
                        alert("No accounts found. Please unlock your wallet.");
                    }
                } catch (error) {
                    console.error(error);
                    alert("Error connecting to wallet. Please check your MetaMask.");
                }
            } else {
                alert("MetaMask is not installed. Please install MetaMask.");
            }
        }

        function disconnectWallet() {
            connected = false;
            document.getElementById('walletInfo').style.display = 'none';
            document.getElementById('connectWallet').style.display = 'block';
            document.getElementById('disconnectWallet').style.display = 'none';
            document.getElementById('walletAddress').textContent = '';
            document.getElementById('balance').textContent = '';
        }

        async function getBalance(walletAddress) {
            const balance = await web3.eth.getBalance(walletAddress);
            const balanceInEth = web3.utils.fromWei(balance, 'ether');
            document.getElementById('balance').textContent = balanceInEth;
        }

        document.getElementById('connectWallet').addEventListener('click', connectWallet);
        document.getElementById('disconnectWallet').addEventListener('click', disconnectWallet);

        document.getElementById('send').addEventListener('click', async () => {
            const recipient = document.getElementById('recipient').value;
            const amount = document.getElementById('amount').value;

            if (!connected) {
                alert("Please connect your wallet first.");
                return;
            }

            if (!web3.utils.isAddress(recipient)) {
                alert("Invalid recipient address.");
                return;
            }

            const weiAmount = web3.utils.toWei(amount, 'ether');
            const walletAddress = document.getElementById('walletAddress').textContent;

            const transactionObject = {
                from: walletAddress, // Added 'from' field
                to: recipient,
                value: weiAmount,
            };

            // Open the wallet extension for transaction confirmation
            await web3.eth.sendTransaction(transactionObject)
                .on('transactionHash', (hash) => {
                    alert("Transaction sent! Transaction hash: " + hash);
                })
                .on('confirmation', (confirmationNumber, receipt) => {
                    alert("Transaction confirmed! Block number: " + receipt.blockNumber);
                })
                .on('error', (error) => {
                    console.error(error);
                    alert("Error sending transaction.");
                });
        });
    </script>

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