<?php

namespace Omnipay\Txprocess\Message;

class TxhandlerRequest extends AbstractRequest
{
	public function getEndpoint()
    {
        return $this->endpoint.'/secure/txHandler.php';
    }
    
    public function sendData($data)
    {
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data
        );

        $httpResponse = $httpRequest->send();   
        
        $this->response = new TxhandlerResponse($this, $httpResponse->getBody());

        return $this->response;
    }
}
