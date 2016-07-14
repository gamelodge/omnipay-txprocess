<?php


namespace Omnipay\Txprocess\Message;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

Class Response extends \Omnipay\Common\Message\AbstractResponse
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
        if($this->data['status'] == 'OK')
            return true;
        else 
            return false;
    }
    public function isRedirect()
       { 
            return false;
       }
   
    public function getErrorMessage()
    {
        return $this->data['error_msg'];
    }
    
    public function getData()
    {
        return $this->data;
    }
    
}
