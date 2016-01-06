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
 *   // Create a gateway for the Txprocess Gateway with card
 *   $gateway = Omnipay::create('TxprocessCard');
 *
 *   // Initialise the gateway
 *   $gateway->initialize($config_gateway);
 *
 *   // Create a credit card object
 *   $card = new CreditCard(array(
 *             'firstName'          => 'Example',
 *             'lastName'           => 'User',
 *             'number'             => '4444333322221111',
 *             'expiryMonth'        => '01',
 *             'expiryYear'         => '2020',
 *             'cvv'                => '321',
 *             'billingAddress1'    => '1 Scrubby Creek Road',
 *             'billingCountry'     => 'AU',
 *             'billingCity'        => 'Scrubby Creek',
 *             'billingPostcode'    => '4999',
 *             'billingState'       => 'QLD',
 *   ));
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
class CardPurchaseRequest extends AbstractRequest
{
     
    
     public function getData()
    {
        $data = parent::getData();
        $card = $this->getCard();
        $card->validate();
        $this->validate('card', $card);
        $type = $card->getBrand()? $card->getBrand() : 'visa';
        
      
        $this->setCardNo($card->getNumber());
        $this->setCardName($card->getName());
        $this->setCardExpMonth($card->getExpiryMonth());
        $this->setCardExpYear($card->getExpiryYear());
        $this->setCardCcv($card->getCvv());
        $this->setCardType($type);
        $this->setTxaction('PAYMENT');
        
        return array_merge($this->getParameters(), $data);
    }

}