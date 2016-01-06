
###To use TxProcessCard (card payment)

     ```php
        // Initialise the gateway
        $gateway = Omnipay::create('TxProcessCard');
        $gateway->initialize();
        $gateway->setSid('2010');
        $gateway->setRcode('zxcasdqwer');
      
        // Do a purchase transaction on the gateway
        $request = $gateway->purchase(array(
            'amount'            => '10.00',
            'currency'          => 'AUD',
            'card'              => array(
                                     'name'=>'Simon Smith',
                                     'number'=>'4222222222222222',
                                     'expiryMonth'=>'06',
                                    'expiryYear'=>'2019',
                                    'cvv'=>'125'
                                ),
            'tid'=> 123, 
            'transactionReference'=> 'payin-45',
            'returnUrl' = 'xxxx', 
            'firstName' = 'asd', 
            'lastName' = 'zxc',
            'email' = 'email@zyz',
            'phone' = '123456',
            'mobile' = '789456'                    
        ));
 
        $response = $request->send();
        if ($response->isSuccessful()) {
            echo "Purchase transaction was successful!\n";
        }

    ```php


###To get TxProcessBank (make a direct payment)

    ```php
        $gateway = Omnipay::create('TxProcessBank');
        $gateway->initialize();
        $gateway->setSid('2010');
        $gateway->setRcode('zxcasdqwer');
      
        // Do a purchase transaction on the gateway
        $request = $gateway->purchase(array(
            'amount'            => '10.00',
            'currency'          => 'AUD',            
            'tid'=> 123, 
            'transactionReference'=> 'payin-45',
            'returnUrl' = 'xxxx', 
            'firstName' = 'asd', 
            'lastName' = 'zxc',
            'email' = 'email@zyz',
            'phone' = '123456',
            'mobile' = '789456',
            ..
            BANK_FORM_DATA_HERER
        ));
 
        $response = $request->send();
        if ($response->isSuccessful()) {
            echo "Purchase transaction was successful!\n";
        }

    ```php

