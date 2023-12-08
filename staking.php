<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>HTHStaking Interface</title>
</head>
<body>
    <div id="walletInfo" style="display: none;">
        <p>Wallet Address: <span id="walletAddress"></span></p>
        <p>Balance: <br><span id="balance"></span> HTHW</p>
    </div>
    <h2>Stake Tokens</h2>
    <form id="stakeTokensForm">
        <label for="stakeAmount">Stake Amount (HTHS):</label>
        <input type="number" step="0.01" id="stakeAmount" name="stakeAmount" required><br>
        <label for="lockTime">Lock Time (seconds):</label>
        <input type="number" id="lockTime" name="lockTime" required><br>
        <button type="button" id="stake">Stake</button>
    </form>
    <h2>Unstake Tokens</h2>
    <button type="button" id="unstake">Unstake</button>

    <script>
        let web3;
        let connected = false;
        let stakingContractAbi; // ABI variable

        async function initWallet() {
            if (typeof window.ethereum !== 'undefined') {
                web3 = new Web3(window.ethereum);

                try {
                    const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                    if (accounts.length > 0) {
                        const walletAddress = accounts[0];
                        document.getElementById('walletAddress').textContent = walletAddress;
                        document.getElementById('walletInfo').style.display = 'block';
                        getBalance(walletAddress);
                        connected = true;
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

        async function loadAbi() {
            // Load ABI from the JSON file
            const response = await fetch('./abi/staking.json');
            stakingContractAbi = await response.json();
        }

        window.addEventListener('load', () => {
            loadAbi(); // Load ABI when the page loads
            initWallet();
        });

        document.getElementById('stake').addEventListener('click', stakeTokens);
        document.getElementById('unstake').addEventListener('click', unstakeTokens);

        async function getBalance(walletAddress) {
            const balance = await web3.eth.getBalance(walletAddress);
            const balanceInEth = web3.utils.fromWei(balance, 'ether');
            document.getElementById('balance').textContent = balanceInEth;
        }

        async function stakeTokens() {
            if (!connected) {
                alert("Please connect your wallet first.");
                return;
            }

            const stakeAmount = document.getElementById('stakeAmount').value;
            const lockTime = document.getElementById('lockTime').value;

            if (isNaN(stakeAmount) || isNaN(lockTime)) {
                alert("Invalid input. Please enter valid numbers for stake amount and lock time.");
                return;
            }

            const stakingContractAddress = "0x7c915Efb15532EC2424A15C38d29B05A1Bb9A13f"; // Replace with your contract address

            const stakingContract = new web3.eth.Contract(stakingContractAbi, stakingContractAddress);

            try {
                const walletAddress = document.getElementById('walletAddress').textContent;
                const weiStakeAmount = web3.utils.toWei(stakeAmount, 'ether');
                const lockTimeInSeconds = parseInt(lockTime);
                const gasPrice = await web3.eth.getGasPrice();

                await stakingContract.methods.stake(weiStakeAmount, lockTimeInSeconds).send({
                    from: walletAddress,
                    gas: 200000, // Adjust the gas limit as needed
                    gasPrice: gasPrice,
                });

                alert(`Staking ${stakeAmount} tokens with a lock time of ${lockTime} seconds.`);
            } catch (error) {
                console.error(error);
                alert("Error staking tokens. Please check the input values and try again.");
            }
        }

        async function unstakeTokens() {
            if (!connected) {
                alert("Please connect your wallet first.");
                return;
            }

            const stakingContractAddress = "0x7c915Efb15532EC2424A15C38d29B05A1Bb9A13f"; // Replace with your contract address

            const stakingContract = new web3.eth.Contract(stakingContractAbi, stakingContractAddress);

            try {
                const walletAddress = document.getElementById('walletAddress').textContent;
                const gasPrice = await web3.eth.getGasPrice();

                await stakingContract.methods.unstake().send({
                    from: walletAddress,
                    gas: 200000, // Adjust the gas limit as needed
                    gasPrice: gasPrice,
                });

                alert("Unstaking tokens.");
            } catch (error) {
                console.error(error);
                alert("Error unstaking tokens. Please try again.");
            }
        }
    </script>
</body>
</html>