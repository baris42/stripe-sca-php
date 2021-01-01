<?php
require_once 'config.php';
//error_reporting(0);
\Stripe\Stripe::setApiKey(SKKEY);
$intent=htmlspecialchars(trim($_GET['intent']));
$intent = Stripe\PaymentIntent::retrieve($intent);
if(isset($intent) && $intent['status']=='succeeded'){
    echo 'ödeme basarili';
}else{
    echo 'odeme basarisiz token'.$_GET['intent'] ;
}
