<?php
/**
 *  Purchase Request
 */
 
namespace Omnipay\Txprocess\Message;

/**
 *  Purchase Request
 *
 *
 * Simple Example:
 *
 * <code>
 *   // Create a gateway for the Txprocess Bank Gateway
 *   $gateway = Omnipay::create('TxprocessBank');
 *
 *   // Initialise the gateway
 *   $gateway->initialize($config_gateway);
 *
 *
 *   // Do a purchase transaction on the gateway
 *   $request = $gateway->purchase(array(
 *      'amount'            => '10.00',
 *      'currency'          => 'AUD',
 *      'transactionType'   => 'Purchase',
 *      'card'              => $card,
 *   ));
 *
 *   $response = $request->send();
 *   if ($response->isSuccessful()) {
 *       echo "Purchase transaction was successful!\n";
 *       $txn_id = $response->getTransactionReference();
 *       echo "Transaction ID = " . $txn_id . "\n";
 *   }
 * </code>
 *

 * @see AbstractRequest
 */
class BankPurchaseRequest extends AbstractRequest
{
     
    
     public function getData()
    {
        $data = parent::getData();
        $this->setTxaction('PREAUTH');
        $type = $this->getPaymethod()? $this->getPaymethod() : 'wire';
        $this->setCardType($type);
        return array_merge($this->getParameters(), $data);
    }

}