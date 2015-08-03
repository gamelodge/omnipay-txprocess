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
            exit($response->getMessage());
        }
    ```php


###To get the transaction status using new api

    ```php
        $params = array(
        'sid' => '1',
        'rcode' => '92202020202020202022'
        )
        $gateway = Omnipay::create('Txprocess_Txprocess');
        $request = $gateway->fetchTransaction($params);
        $request->setPtxid($ptxid); //parent txid
        $response = $request->send();
        print_r($response->getData());
    ```php
