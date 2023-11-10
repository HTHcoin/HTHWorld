<?php
session_start();
include('includes/config.php');
  require_once('vendor/autoload.php');
  require_once('lib/pdo_db.php');
  require_once('models/Customer.php');
  require_once('models/Transaction.php');

  \Stripe\Stripe::setApiKey('sk_live_lyoV9UxuX71ah21snrJmqcpA');

 // Sanitize POST Array
 $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$donation_amount = $POST['donation_amount'];

 $first_name = $POST['first_name'];
 $last_name = $POST['last_name'];
 $email = $POST['email'];
 $token = $POST['stripeToken'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
    "amount" => $donation_amount * 100, // Convert the amount to cents (Stripe requires the amount in cents)
    "currency" => "usd",
    "description" => "HTH Donations",
    "customer" => $customer->id
));

// Customer Data
$customerData = [
  'id' => $charge->customer,
  'first_name' => $first_name,
  'last_name' => $last_name,
  'email' => $email
];

// Instantiate Customer
$customer = new Customer();

// Add Customer To DB
$customer->addCustomer($customerData);


// Transaction Data
$transactionData = [
  'id' => $charge->id,
  'customer_id' => $charge->customer,
  'product' => $charge->description,
  'amount' => $charge->amount,
  'currency' => $charge->currency,
  'status' => $charge->status,
];

// Instantiate Transaction
$transaction = new Transaction();

// Add Transaction To DB
$transaction->addTransaction($transactionData);

// Redirect to success
header('Location: success.php?tid='.$charge->id.'&product='.$charge->description);