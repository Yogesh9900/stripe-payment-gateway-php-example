<?php
require_once('stripe-php-7/init.php');

$stripe = array(
  "secret_key"      => "YOUR_SECRETE_KEY",
  "publishable_key" => "YOUR_PUBLISH_KEY"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>