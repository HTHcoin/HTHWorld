// Import web3.js library (make sure you have it included)
const Web3 = require('web3');

// Initialize web3 with your Ethereum provider (e.g., Infura or your local node)
const web3 = new Web3('https://rpc0.altcoinchain.org/rpc');

// Replace with your contract address and ABI
const contractAddress = '0x4AF28E6AA2281C6dF5e5b4602004197Fba523F5c'; // Your contract address
const contractABI = require('./abi/donations.json'); // Import your contract's ABI

// Create a contract instance
const donationContract = new web3.eth.Contract(contractABI, contractAddress);

// Function to make a donation
async function makeDonation(donationAmount, donationPurpose) {
    try {
        const accounts = await web3.eth.getAccounts();
        const donationAmountWei = web3.utils.toWei(donationAmount, 'ether');
        const result = await donationContract.methods.donate(donationPurpose).send({
            from: accounts[0],
            value: donationAmountWei,
        });
        return result;
    } catch (error) {
        throw error;
    }
}

// Function to retrieve donation details
async function getDonations() {
    try {
        const donations = await donationContract.methods.getDonations().call();
        return donations;
    } catch (error) {
        throw error;
    }
}

// Example usage:
// makeDonation('1', 'Example Purpose')
//     .then((result) => {
//         console.log('Donation successful. Transaction Hash: ', result.transactionHash);
//     })
//     .catch((error) => {
//         console.error('Error making donation: ', error);
//     });

// getDonations()
//     .then((donations) => {
//         console.log('Donation Details: ', donations);
//     })
//     .catch((error) => {
//         console.error('Error getting donations: ', error);
//     });