<?php
/**
 *  Purchase Request
 */
 
namespace Omnipay\Txprocess\Message;

/**
 *  Purchase Request
 *
 * Completes a transaction using eWAY's Rapid Direct Connection API.
 * This request can process a purchase with card details or with an
 * eWAY Token (passed as the cardReference).
 *
 * Using Direct Connection to pass card details in the clear requires
 * proof of PCI compliance to eWAY. Alternatively they can be 
 * encrypted using Client Side Encryption - in which case the card 
 * number and CVN should be passed using the encryptedCardNumber and
 * encryptedCardCvv respectively (these are not in the CreditCard
 * object).
 *
 * Simple Example:
 *
 * <code>
 *   // Create a gateway for the eWAY Direct Gateway
 *   $gateway = Omnipay::create('Eway_RapidDirect');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *      'apiKey' => 'Rapid API Key',
 *      'password' => 'Rapid API Password',
 *      'testMode' => true, // Or false when you are ready for live transactions
 *   ));
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

 * @see CardAbstractRequest
 */
class PurchaseRequest extends AbstractRequest
{
     
    /**
     * Get transaction endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return 'http://txprocess.uat.ipayoptions.com/secure/txHandler.php';
    }
    
     public function getData()
    {
        $items = $this->getParameter('items');
        $itemArray = [];

        $total = 0;
        foreach($items as $index => $item) {

            $total += $item['quantity'] * $item['amount_unit'];

            foreach($item as $k => $v) {
                $itemArray['item_' . $k . '[' . $index . ']'] = $v;
            }                
        }
        $total += $this->getAmountShipping() + $this->getAmountTax() - $this->getAmountCoupon();
        $this->setHash($this->generateHash($total));
            
        return array_merge($this->getParameters(), $itemArray);
    }
   
     public function generateHash($total)
    {
        return md5($this->getSid() . $this->getTimestamp() . number_format($total, 2, '.', '') . $this->getCurrency() . $this->getRcode());
    }

}