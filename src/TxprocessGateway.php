<?php

namespace Omnipay\Txprocess;

use Omnipay\Common\AbstractGateway;
/**
 * make payment through the swagger api
 */
class TxprocessGateway extends AbstractGateway {
     public function getName() {
        return 'Txprocess';
    }

     /**
     * Get the gateway parameters
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'sid' => '',
            'rcode' => '',
            'ptxid' => ''
        );
    }
    
   

    /**
     * @param array $parameters
     * @return \Omnipay\Stripe\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Txprocess\Message\FetchTransactionRequest', $parameters);
    }

    
}
