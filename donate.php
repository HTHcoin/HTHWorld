<?php
session_start();

// Include Stripe SDK
require 'vendor/autoload.php';

// Stripe API Keys
\Stripe\Stripe::setApiKey('YOUR_STRIPE_KEY_KEY');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['donate_amount'])) {
        $donate_amount = $_POST['donate_amount'];
        $payment_method = $_POST['payment_method'];

        if ($payment_method == 'stripe') {
            // Create a Stripe Payment Intent
            $donate_amount_cents = $donate_amount * 100;
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $donate_amount_cents,
                'currency' => 'usd',
            ]);

            // Redirect to Stripe payment confirmation page
            header("Location: stripe_payment_confirmation.php?payment_intent=" . $intent->client_secret);
            exit;
        } elseif ($payment_method == 'paypal') {
            // Replace 'client_id' and 'client_secret' with your PayPal API credentials
            $client_id = 'YOU_PAYPAL_CLIENT_KEY';
            $client_secret = 'YOUR_PAYPAL_SECRET_KEY';

            $paypal = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
            );

            // Create a PayPal Payment
            $payment = new \PayPal\Api\Payment();
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new \PayPal\Api\Amount();
            $amount->setTotal($donate_amount);
            $amount->setCurrency('USD');

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount);

            $payment->setIntent('sale');
            $payment->setPayer($payer);
            $payment->setTransactions([$transaction]);

            // Set PayPal return and cancel URLs
            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl('paypal_payment_confirmation.php?success=true');
            $redirectUrls->setCancelUrl('paypal_payment_confirmation.php?success=false');
            $payment->setRedirectUrls($redirectUrls);

            try {
                $payment->create($paypal);
                header("Location: " . $payment->getApprovalLink());
                exit;
            } catch (Exception $ex) {
                echo "Error: " . $ex->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Today</title>
    <link rel="stylesheet" href="css/style.css">
<script>
document.addEventListener("DOMContentLoaded", function () {
    var donationTypeSelect = document.getElementById("donation_type");
    var amountSelection = document.getElementById("amount_selection");

    donationTypeSelect.addEventListener("change", function () {
        if (donationTypeSelect.value === "recurring") {
            amountSelection.style.display = "none";
        } else {
            amountSelection.style.display = "block";
        }
    });
});
</script>

</head>
<body>
    <header>
        <h1>Donate Today</h1>
        <p>Help Support Our Cause</p>
    </header>

    <?php include('navbar.php'); ?>

    <main>
        <section id="donate">
            <h2>Donate Today</h2>
            <p>Your donation can make a significant impact. Choose a platform to donate:</p>
            <form method="POST" action="">
                <label for="donation_type">Donation Type:</label>
                <select id="donation_type" name="donation_type" required>
                    <option value="one-time">One-Time</option>
                    <option value="recurring">Recurring</option>
                </select>
                <div id="amount_selection">
                    <label for="donate_amount">Donation Amount:</label>
                    <input type="number" step="0.01" id="donate_amount" name="donate_amount" required>
                </div>
                <label for="payment_method">Choose Payment Method:</label>
                <select id="payment_method" name="payment_method">
                    <option value="stripe">Stripe</option>
                    <option value="paypal">PayPal</option>
                </select>
                <button type="submit" class="donate-button">Donate</button>
            </form>
        </section>
    </main>

    <?php include('footer.php'); ?>

</body>
</html>