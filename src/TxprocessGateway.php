<?php

namespace Omnipay\Txprocess;

use Omnipay\Common\AbstractGateway;
/**
 * make payment through the txprocess api
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
            'ptxid' => '',
            'endpoint'=> ''
        );
    }
  
  
    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value.'/secure/txHandler.php');
    }
    
    public function getSid()
    {
        return $this->getParameter('sid');
    }
    public function setSid($value)
    {
        return $this->setParameter('sid', $value);
    }
    public function getRcode()
    {
        return $this->getParameter('rcode');
    }
    public function setRcode($value)
    {
        return $this->setParameter('rcode', $value);
    }
     public function getPtxid()
    {
        return $this->getParameter('ptxid');
    }
    public function setPtxid($value)
    {
        return $this->setParameter('ptxid', $value);
    }
    
    public function setPaymethod($value)
    {
        $this->setParameter('paymethod', $value);
    }

    public function getPaymethod()
    {
        return $this->getParameter('paymethod');
    }
   
}
