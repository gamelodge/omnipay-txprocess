# TxprocessTxhandler
Previous index file is renamed as testtxhandlerpayment.php


To get Txhandler fields (card payment)
<pre>
`
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $gateway->initialize();
    $default = $gateway->getParameters();
    $card = $gateway->getCardFields();
     $fields = array_merge($default,$fields);
`
</pre>

To get Txhandler fields (bank payment)
<pre>
```php
    $gateway = Omnipay::create('Txprocess_Txhandler');
    $gateway->initialize();
    $default = $gateway->getParameters();
    $card = $gateway->getBankFields();
    $fields = array_merge($default,$fields);
```php
</pre>
To make a direct payment using secure/txhandler
    __params are the field for your payment type__
<pre>
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
</pre>
To get the transaction status using new api
<pre>
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
</pre>