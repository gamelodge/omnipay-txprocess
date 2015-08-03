<?php
namespace Omnipay\Txprocess\Message;
use Omnipay\Common\Message\AbstractResponse;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
class TxhandlerResponse extends AbstractResponse
{
    
    public function getRedirectResponse()
    {
        if(!$this->isRedirect())
            throw new RuntimeException('This response does not support redirection.');

        $output = json_encode($this->getData());
        return HttpResponse::create($output);
    }
    public function isSuccessful()
    {
        return false;
    }
    public function isRedirect()
    {
        return true;
    }
   
     public function getData()
    {
        return json_encode($this->data);
    }
    
}