<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:login.php');
} else {
    $email = $_SESSION['alogin'];
}
?>

<!doctype html>
<html lang="en" class="no-js">

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

/* Style for the page title */
h1, h2 {
    text-align: center;
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

/* Style for the form and labels */
form {
    max-width: 300px;
    margin: 0 auto;
}

label {
    display: block;
    margin-top: 10px;
    color: #333;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Style for the submit button */
button[type="button"] {
    background-color: #008CBA;
}

/* Style for the wallet information */
#walletInfo {
    text-align: center;
    margin: 20px auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    max-width: 300px;
}

/* Style for the balance and wallet address */
#walletAddress,
#balance {
    font-weight: bold;
    color: #333;
}

/* Style for error messages */
.alert {
    background-color: #f44336;
    color: white;
    padding: 10px;
    text-align: center;
    border-radius: 4px;
    margin-top: 10px;
}

</style>
    <title>Ethereum Wallet Interaction</title>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
    <h1>Ethereum Wallet Interaction</h1>
    <button id="connectWallet">Connect to Wallet</button>
    <button id="disconnectWallet" style="display: none;">Disconnect Wallet</button>
    <div id="walletInfo" style="display: none;">
        <p>Wallet Address: <span id="walletAddress"></span></p>
        <p>Balance: <span id="balance"></span> ETH</p>
    </div>
    <h2>Send Funds</h2>
    <form id="sendFundsForm">
        <label for="recipient">Recipient Address:</label>
        <input type="text" id="recipient" name="recipient" required><br>
        <label for="amount">Amount (ETH):</label>
        <input type="number" step="0.01" id="amount" name="amount" required><br>
        <button type="button" id="send">Send</button>
    </form>

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