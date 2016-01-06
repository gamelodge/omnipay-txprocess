<?php

namespace Omnipay\Txprocess;

/**
 * make payment through the swagger api
 */
class TxprocessBankGateway extends TxprocessGateway {
    
     public function getName() {
        return 'TxprocessBank';
    }

   
    /**
     * Create a purchase request.
     *
     * Used for initiating a purchase transaction.
     * 
     * @param array $parameters
     * @return \Txfunds\OmnipayBundle\Txprocess\Message\CardPurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Txfunds\OmnipayBundle\Txprocess\Message\BankPurchaseRequest', $parameters);
    }
    
    
}
