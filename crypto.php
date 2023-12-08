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

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
            margin: 20px 0;
            background: #dd3d36;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 20px 0;
            background: #5cb85c;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

h1 {
text-align: center;
color: #debf12;
}

        .donate-container {
            text-align: center;
            background-color: #333;
            padding: 20px;
            border-color: #34bcaa;
        }

        .donate-container h2 {
            font-size: 24px;
            color: #debf12;
        }

        .donate-container p {
            font-size: 16px;
            color: #fff;
        }

th {
text-align: center;
color: #debf12;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
    color: #34bcaa;
}

    </style>

    <script src="https://cdn.jsdelivr.net/npm/web3@1.6.0/dist/web3.min.js"></script>

    <title>HTHW Donations</title>
</head>
<body>

    <!-- Include your website header or navigation here -->
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <!-- Include your left sidebar or any content here -->
        <?php include('includes/leftbar.php'); ?>
    </div>
</br>
</br>
</br>
    <h1>HTHW Donations</h1>
    
    <h2>Donation Contract Information</h2>
    <p>Contract Address: 0x5F89e9052b94E86eDd05EDb219CbAd40bA4A8B75</p>
    <p>Owner Address: 0x6bf9c224cfd115484b4d1c22bc92c0c3461c28e1</p>

<div class="donate-container" style="border: 2px solid #debf12; box-shadow: 2px 2px 2px #34bcaa; margin: 0 auto; width: 50%">
    <h2 style="color: #debf12;">Donate HTHW</h2>
    <form id="donationForm" onsubmit="donateEther(); return false;">
        <input type="number" id="donationAmount" step="0.01" placeholder="Amount (HTHW)" required>
        <button type="submit">Donate</button>
    </form>
</div>

    <h2>Your Donations</h2>
    <table class="table table-bordered" style="border: 2px solid #debf12; box-shadow: 2px 2px 2px #34bcaa; margin: 0 auto; width: 50%">
        <thead>
            <tr>
                <th>Address</th>
                <th>Donation (HTHW)</th>
            </tr>
        </thead>
        <tbody id="donationListTable">
        </tbody>
    </table>

    <script>
        // Load the contract ABI from a JSON file
        const contractAbi = <?php echo file_get_contents('./abi/donations.json'); ?>;

        // Connect to the Ethereum network using web3.js
        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
        } else {
            // If web3 is not present, provide an error message
            console.error('Please install a web3 browser extension like MetaMask');
        }

        // Define your contract's address
        const contractAddress = '0x5F89e9052b94E86eDd05EDb219CbAd40bA4A8B75';

        const contract = new web3.eth.Contract(contractAbi, contractAddress);

        // Function to donate Ether
        async function donateEther() {
            const donationAmount = document.getElementById('donationAmount').value;

            // Get the current Ethereum account (assuming MetaMask is used)
            const accounts = await ethereum.request({ method: 'eth_accounts' });
            const senderAddress = accounts[0];

            try {
                // Send the donation transaction
                await contract.methods.donate().send({
                    from: senderAddress,
                    value: web3.utils.toWei(donationAmount, 'ether'),
                });

                alert('Donation successful!');
                displayDonations(); // Refresh the donation list after a donation
            } catch (error) {
                alert('Donation failed: ' + error.message);
            }
        }

        // Function to fetch and display the list of donors and their donations
        async function displayDonations() {
            const donators = await contract.methods.showAllDonators().call();

            const donationListTable = document.getElementById('donationListTable');
            donationListTable.innerHTML = '';

            for (const donatorAddress of donators) {
                const donationSum = await contract.methods.showDonationSum(donatorAddress).call();
                const donationRow = document.createElement('tr');
                
                const addressCell = document.createElement('td');
                addressCell.innerText = donatorAddress;
                
                const donationCell = document.createElement('td');
                donationCell.innerText = web3.utils.fromWei(donationSum, 'ether') + ' HTHW';

                donationRow.appendChild(addressCell);
                donationRow.appendChild(donationCell);
                donationListTable.appendChild(donationRow);
            }
        }

        // Call the function to display the list of donations when the page loads
        displayDonations();
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
