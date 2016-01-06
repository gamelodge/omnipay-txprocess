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
        if (LuhnCheckCardNumber($this->getNumber())) {
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

     // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
     $number=preg_replace('/\D/', '', $number);

     // Set the string length and parity
     $number_length=strlen($number);
     $parity=$number_length % 2;

     // Loop through each digit and do the maths
     $total=0;
     for ($i=0; $i<$number_length; $i++) {
       $digit=$number[$i];
       // Multiply alternate digits by two
       if ($i % 2 == $parity) {
         $digit*=2;
         // If the sum is two digits, add them together (in effect)
         if ($digit > 9) {
           $digit-=9;
         }
       }
       // Total up the digits
       $total+=$digit;
     }

     // If the total mod 10 equals 0, the number is valid
     return ($total % 10 == 0) ? TRUE : FALSE;

   }

}