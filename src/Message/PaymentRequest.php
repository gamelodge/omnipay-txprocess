<?php

namespace Omnipay\Txprocess\Message;

class PaymentRequest extends AbstractRequest
{
	public function getEndpoint()
    {
        return $this->endpoint.'/secure/txHandler.php';
    }
}
