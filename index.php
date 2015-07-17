<?php

	require_once "vendor/autoload.php";
	use Omnipay\Omnipay;

	function genHash($sid, $time, $total, $currency, $rcode)
	{
		$ooo = [$sid, $time, $total, $currency, $rcode];

		echo '<pre>';
		print_r($ooo);
		echo '</pre>';

		return md5($sid . $time . $total . $currency . $rcode);
	}

	$gateway = Omnipay::create('Txprocess');
	$gateway->setSid(1);
	$gateway->setRcode('9ff1a10f0a09b9388b5664f2dc1001e748c5b999');

	$time = time();
	$total = '10.00';
	$currency = 'USD';

	$items[] = [
		'quantity' => 1,
		'name' =>'Depositing 10.00 USD',
		'no' => 'DEP',
		'desc' => 'DemoUSD Account(58390921)',
		'amount_unit' => '10.00',
	];

	/*'item_quantity[0]' => 1,
	'item_name[0]' => 'Depositing 10.00 USD',
	'item_no[0]' => 'DEP',
	'item_desc[0]' => 'DemoUSD Account(58390921)',
	'item_amount_unit[0]' => '10.00',*/

	$option = [
		'tid' => 84,

		'postback_url' => 'http://txfunds1.aunn.dev.ipo-servers.net%2Fpostback%2Ftxprocess.php',
		'redirect_url' => 'http://txfunds1.aunn.dev.ipo-servers.net/deposit/return.php',
		//'hash' => genHash($gateway->getSid(), $time, $total, $currency, $gateway->getRcode()),
		'timestamp' => $time,

		'card_type' => 'visa',
		'card_name' => 'Name Surname',
		'card_no' => '4556334519878501',
		'card_ccv' => 159,
		'card_exp_month' => 10,
		'card_exp_year' => 2018,

		'bank_name' => 'bank_name',
		'bank_phone' => 'bank_phone',

		'username' => 'username',
		'password' => 'password',

		'firstname' => 'pang',
		'lastname' => 'kaka',
		'phone' => '0892398710',
		'email' => 'aunn_it08@hotmail.com',
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
		'amount_coupon' => 0, 	//optional
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

	echo genHash($gateway->getSid(), $time, $total, $currency, $gateway->getRcode()) . '||||';

	$gateway->payment($option)->send();