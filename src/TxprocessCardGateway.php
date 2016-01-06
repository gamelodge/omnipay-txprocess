<?php

namespace Omnipay\Txprocess;

/**
 * make payment through the swagger api
 */
class TxprocessCardGateway extends TxprocessGateway {
    
     public function getName() {
        return 'TxprocessCard';
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
        return $this->createRequest('\Omnipay\Txprocess\Message\CardPurchaseRequest', $parameters);
    }
    
    
}
