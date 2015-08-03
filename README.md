# TxprocessTxhandler
Previous index file is renamed as testtxhandlerpayment.php


###To get Txhandler fields (card payment)

    `
        $gateway = Omnipay::create('Txprocess_Txhandler');
        $gateway->initialize();
        $default = $gateway->getParameters();
        $card = $gateway->getCardFields();
        $fields = array_merge($default,$fields);
    `


###To get Txhandler fields (bank payment)

    ```php
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $gateway->initialize();
    $default = $gateway->getParameters();
    $card = $gateway->getBankFields();
    $fields = array_merge($default,$fields);
    ```php


###To make a direct payment using secure/txhandler
    __params are the fields for your payment type__


    ```php
        $gateway = Omnipay::create('Txprocess_Txhandler');
        $response = $gateway->purchase($params)->send();

        if ($response->isRedirect()) {

                $response->redirect();
            }
         else {
            // display error to customer
            exit($response->getData());
        }
    ```php


###To get the transaction status using new api

    ```php
        $params = array(
            'sid' => '1',
            'rcode' => '9ff1a10f0a09b9388b5664f2dc1001e748c5b999',                        
            'postback_url' => 'http://yourwebsite.com/postback.php',
            'timestamp' => '123456789',
            'card_type' => 'visa',
            'card_name' => 'Mike mustermann',
            'card_no' => '4111111111111111',
            'card_ccv' => '001',
            'card_exp_month' => '05',
            'card_exp_year' => '2018',
            'firstname' => 'Mike',
            'lastname' => 'Mustermann',
            'email' => 'mike@mustermann.com',
            'phone' => '1234567890',
            'currency' => 'USD',
            'address' => '12 Test Lane',
            'suburb_city' => 'Testville',
            'state' => 'TS',
            'postcode' => '12345',
            'country' => 'US',
            'amount_shipping' => '0.02',
            'amount_coupon' => '0.00',
            'amount_tax' => '0.00',
            'item_quantity[]' => '1',
            'item_name[]' => 'apple',
            'item_no[]' => 'a234',
            'item_desc[]' => 'juicy green apple',
            'item_amount_unit[]' => '5.20',
            'tid' => '123',
            'tx_action' => 'PAYMENT');

        $gateway = Omnipay::create('Txprocess_Txprocess');
        $request = $gateway->fetchTransaction($params);
        $request->setPtxid($ptxid); //parent txid
        $response = $request->send();
        print_r($response->getData());

    ```php

###Make payment transaction status using new api

    ```php
        $params = array(
        'sid' => '1',
        'rcode' => '92202020202020202022'
        )
        $gateway = Omnipay::create('Txprocess_Txprocess');
        $response = $gateway->purchase($params)->send();
        print_r($response->getData());
    ```php
