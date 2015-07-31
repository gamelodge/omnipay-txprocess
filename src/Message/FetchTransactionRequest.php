<?php

namespace Omnipay\Txprocess\Message;

class FetchTransactionRequest extends AbstractRequest
{
    
    public function getEndpoint()
    {
        return $this->endpoint.$this->getPtxid().'/getStatus';
    }
    public function getHttpMethod()
    {
        return 'GET';
    }
   
        public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );
        //find problem sending parameter array seperate when doing guzzle get call. 
        //sending it through the querystring solves the problem
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint().'?'.http_build_query($data),
            null,
           $data
        );
        
        $httpResponse = $httpRequest->send();
        return $this->response = new Response($this, $httpResponse->json());
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
}