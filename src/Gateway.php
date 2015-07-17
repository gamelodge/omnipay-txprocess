<?php

namespace Omnipay\Txprocess;

use Omnipay\Common\AbstractGateway;
use Omnipay\Txprocess\Message\PurchaseRequest;
use Omnipay\Txprocess\Message\RefundRequest;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Txprocess';
    }

    /*public function getDefaultParameters()
    {
        return [
            'sid' => '',
            'rcode' => '',
        ];
    }*/

    public function getSid()
    {
        return $this->getParameter('sid');
    }

    public function setSid($sid)
    {
        $this->setParameter('sid', $sid);
        return $this;
    }

    public function getRcode()
    {
        return $this->getParameter('rcode');
    }

    public function setRcode($rcode)
    {
        $this->setParameter('rcode', $rcode);
        return $this;
    }

    public function payment(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Txprocess\Message\PaymentRequest', $parameters);
    }
}
