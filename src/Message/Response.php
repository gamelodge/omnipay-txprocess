<?php


namespace Omnipay\Txprocess\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return !isset($this->data['error']);
    }
}
