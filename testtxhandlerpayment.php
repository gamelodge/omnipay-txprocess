<?php

require_once "vendor/autoload.php";

use Omnipay\Omnipay;

function genHash($sid, $time, $total, $currency, $rcode) {
    return md5($sid . $time . $total . $currency . $rcode);
}

$gateway = Omnipay::create('Txprocess_Txhandler');

$time = time();
$total = '10.00';
$currency = 'USD';

$items[] = [
    'quantity' => 1,
    'name' => 'Depositing 10.00 USD',
    'no' => 'DEP',
    'desc' => 'DemoUSD Account(58390921)',
    'amount_unit' => '10.00',
];

/* 'item_quantity[0]' => 1,
  'item_name[0]' => 'Depositing 10.00 USD',
  'item_no[0]' => 'DEP',
  'item_desc[0]' => 'DemoUSD Account(58390921)',
  'item_amount_unit[0]' => '10.00', */

$option = [
    'sid' => 1,
    'rcode' => '9ff1a10f0a09b9388b5664f2dc1001e748c5b999',
    'tid' => 84,
    'postback_url' => 'http://xxxx/secure/postback.php',
    'redirect_url' => 'http://xxxxx/testreturn.php',
    //'hash' => genHash($gateway->getSid(), $time, $total, $currency, $gateway->getRcode()),
    'timestamp' => $time,
    'card_type' => 'visa',
    'card_name' => 'FirstName Surname',
    'card_no' => '4111111111111111',
    'card_ccv' => 159,
    'card_exp_month' => 10,
    'card_exp_year' => 2018,
    'bank_name' => 'bank_name',
    'bank_phone' => 'bank_phone',
    'username' => 'username',
    'password' => 'password',
    'firstname' => 'mike',
    'lastname' => 'smith',
    'phone' => '0892398710',
    'email' => 'test@example.com',
    'mobile' => 'mobile',
    'address' => '',
    'suburb_city' => '',
    'state' => '',
    'postcode' => '',
    'country' => '',
    'shipping_firstname' => 'shipping_firstname',
    'shipping_lastname' => 'shipping_lastname',
    'shipping_address' => 'shipping_address',
    'shipping_suburb_city' => 'shipping_suburb_city',
    'shipping_state' => 'shipping_state',
    'shipping_postcode' => 'shipping_postcode',
    'shipping_country' => 'shipping_country',
    'currency' => $currency,
    'amount_shipping' => 0,
    'amount_coupon' => 0, //optional
    'amount_tax' => 0,
    'tx_action' => 'PAYMENT',
    'items' => $items,
    'campaignid[0]' => 1,
    'affiliateid' => 1,
    'ref1' => 'txprocess-84',
    'ref2' => 'txprocess-84',
    'ref3' => 'txprocess-84',
    'ref4' => 'txprocess-84',
];

$request = $gateway->purchase($option);
try {
    $response = $request->send();
//    var_dump($response);
////    print_r($response->isSuccessful());
//    exit;
    if ($response->isRedirect()) {

            $response->redirect();
        }
     else {
        // display error to customer
        exit($response->getMessage());
    }
} catch (\Exception $e) {
    // internal error, log exception and display a generic message to the customer
    exit('Sorry, there was an error processing your payment. Please try again later.'.$e->getMessage());
}

	
