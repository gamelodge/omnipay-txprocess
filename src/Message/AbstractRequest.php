<?php

namespace Omnipay\Txprocess\Message;

//// TODO : don't forget campaignid[]
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'http://txprocess.geena.dev.ipo-servers.net/api/api.php/';

    
    public function getHttpMethod()
    {
        return 'POST';
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
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
           $data
        );
        $httpResponse = $httpRequest->send();
        return $this->response = new Response($this, $httpResponse->json());
    }

    public function getData()
    {
       
        return $this->getParameters();
    }

   
}
