<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:login.php');
} else {
    $email = $_SESSION['alogin'];
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>HTHW Wallet</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <h1>HTHW Wallet</h1>
            <button id="connectWallet">Connect to Wallet</button>
            <button id="disconnectWallet" style="display: none;">Disconnect Wallet</button>
            <div id="walletInfo" style="display: none;">
                <p>Wallet Address: <span id="walletAddress"></span></p>
                <p>Balance: <br><span id="balance"></span> HTHW</p>
            </div>
            <h2>Send Funds</h2>
            <form id="sendFundsForm">
                <label for="recipient">Recipient Address:</label>
                <input type="text" id="recipient" name="recipient" required><br>
                <label for="amount">Amount (ETH):</label>
                <input type="number" step="0.01" id="amount" name="amount" required><br>
                <button type="button" id="send">Send</button>
            </form>
        </div>
    </div>

    <!-- Include the JavaScript code for wallet interaction -->
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let web3;
        let connected = false;

        async function initWallet() {
            if (typeof window.ethereum !== 'undefined') {
                web3 = new Web3(window.ethereum);

                try {
                    // Enable the wallet and get accounts
                    const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                    if (accounts.length > 0) {
                        const walletAddress = accounts[0];
                        document.getElementById('walletAddress').textContent = walletAddress;
                        document.getElementById('walletInfo').style.display = 'block';
                        getBalance(walletAddress);
                        connected = true;
                        document.getElementById('connectWallet').style.display = 'none';
                        document.getElementById('disconnectWallet').style.display = 'block';
                    } else {
                        alert("No accounts found. Please unlock your wallet.");
                    }
                } catch (error) {
                    console.error(error);
                    alert("Error connecting to the wallet. Please check your MetaMask.");
                }
            } else {
                alert("MetaMask is not installed. Please install MetaMask.");
            }
        }

        async function disconnectWallet() {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    await ethereum.request({ method: 'eth_requestAccounts' });
                    connected = false;
                    document.getElementById('walletInfo').style.display = 'none';
                    document.getElementById('connectWallet').style.display = 'block';
                    document.getElementById('disconnectWallet').style.display = 'none';
                    document.getElementById('walletAddress').textContent = '';
                    document.getElementById('balance').textContent = '';
                } catch (error) {
                    console.error(error);
                }
            }
        }

        window.addEventListener('load', () => {
            initWallet();
        });

        document.getElementById('connectWallet').addEventListener('click', () => {
            initWallet();
        });

        document.getElementById('disconnectWallet').addEventListener('click', () => {
            disconnectWallet();
        });

        async function getBalance(walletAddress) {
            const balance = await web3.eth.getBalance(walletAddress);
            const balanceInEth = web3.utils.fromWei(balance, 'ether');
            document.getElementById('balance').textContent = balanceInEth;
        }

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
                from: walletAddress,
                to: recipient,
                value: weiAmount,
            };

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

</body>

</html>
