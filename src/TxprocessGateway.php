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
    
   public function buildItems(&$params)
    {
        if(!isset($params['items']))
        {
            $items= array();
            foreach($params['item_quantity'] as $index => $val) {
                $items['quantity'] = $params['item_quantity'][$index];
                $items['name'] = $params['item_name'][$index];
                $items['no'] = $params['item_no'][$index];
                $items['desc'] = $params['item_desc'][$index];
                $items['amount_unit'] = $params['item_amount_unit'][$index];
                $params['items'][] = $items;
            }
             //unset the item_ array items 
            unset($params['item_quantity']);
            unset($params['item_name']);
            unset($params['item_no']);
            unset($params['item_desc']);
            unset($params['item_amount_unit']);
            
        }
       
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Stripe\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Txprocess\Message\FetchTransactionRequest', $parameters);
    }

    
    public function purchase(array $parameters = array()) {
        $this->buildItems($parameters);
        
        $request = $this->createRequest('\Omnipay\Txprocess\Message\SoapRequest', $parameters);

        return $request;
    }
    
}
