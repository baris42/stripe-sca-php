<?php
header('Content-Type: application/json');
require_once 'config.php';
// This is a sample test API key. Sign in to see examples pre-filled with your key.
\Stripe\Stripe::setApiKey(SKKEY);


try {
  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);

  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => 1400,
    'currency' => 'try',
      'statement_descriptor' => 'Custom descriptor',
      'description' => 'lalalo',
           'metadata' => [
          'order_id' => '6735',
      ],
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret,
  ];

 echo json_encode($output);

} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}