# TxprocessTxhandler
Previous index file is renamed as testtxhandlerpayment.php


To get Txhandler fields (card payment)
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $gateway->initialize();
    $card = $gateway->getCardFields();

To get Txhandler fields (bank payment)
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $gateway->initialize();
    $card = $gateway->getBankFields();

To make a direct payment using secure/txhandler
    //params are the field for your payment type
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $response = $gateway->purchase($params)->send();

    if ($response->isRedirect()) {

            $response->redirect();
        }
     else {
        // display error to customer
        exit($response->getMessage());
    }

To get the transaction status using new api
        $params = array(
        'sid' => '1',
        'rcode' => '92202020202020202022'
        )
        $gateway = Omnipay::create('Txprocess_Txprocess');
        $request = $gateway->fetchTransaction($params);
        $request->setPtxid($ptxid); //parent txid
        $response = $request->send();
        print_r($response->getData());