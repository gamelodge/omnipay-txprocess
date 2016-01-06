<?php
/**
 *  Purchase Request
 */
 
namespace Omnipay\Txprocess\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
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
        if (!$this->LuhnCheckCardNumber($card->getNumber())) {
            throw new InvalidCreditCardException('Card number is invalid');
        }
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
    
    /* Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org *
    * This code has been released into the public domain, however please      *
    * give credit to the original author where possible.                      */

   function LuhnCheckCardNumber($number) {
        $cards = array(
            "visa" => "(4\d{12}(?:\d{3})?)",
            "amex" => "(3[47]\d{13})",
            "jcb" => "(35[2-8][89]\d\d\d{10})",
            "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
            "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
            "mastercard" => "(5[1-5]\d{14})",
            "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
        );
        $names = array("Visa", "American Express", "JCB", "Maestro", "Solo", "Mastercard", "Switch");
        $matches = array();
        $pattern = "#^(?:".implode("|", $cards).")$#";
        $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
        if($extra_check && $result > 0){
            $result = (validatecard($cc))?1:0;
        }
        return ($result>0)?$names[sizeof($matches)-2]:false;
   }

}