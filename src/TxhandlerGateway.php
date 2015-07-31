<?php

namespace Omnipay\Txprocess;

//use Omnipay\Txprocess\Gateway;
use Omnipay\Common\AbstractGateway;
class TxhandlerGateway extends AbstractGateway  {

     public function getDefaultParameters()
    {
        $settings = parent::getDefaultParameters();
        $settings['sid'] = '';
        $settings['rcode'] = '';
        $settings['tid'] = '';
        $settings['postback_url'] = '';
        $settings['redirect_url'] = '';
        $settings['timestamp'] = '';
        $settings['firstname'] = '';
        $settings['lastname'] = '';
        $settings['address'] = '';
        $settings['suburb_city'] = '';
        $settings['state'] = '';
        $settings['postcode'] = '';
        $settings['country'] = '';
        $settings['email'] = '';
        $settings['phone'] = '';
        $settings['currency'] = '';
        $settings['shipping_firstname'] = '';
        $settings['shipping_lastname'] = '';
        $settings['shipping_address'] = '';
        $settings['shipping_suburb_city'] = '';
        $settings['shipping_state'] = '';
        $settings['shipping_postcode'] = '';
        $settings['shipping_country'] = '';
        $settings['amount_shipping'] = '0.00';
        $settings['amount_coupon'] = '0.00';
        $settings['amount_tax'] = '0.00';
        $settings['item_quantity[]'] = '1';
        $settings['item_name[]'] = '';
        $settings['item_no[]'] = '';
        $settings['item_desc[]'] = '';
        $settings['item_amount_unit[]'] = '0.00';
        $settings['tx_action'] = array('PREAUTH','PAYMENT');
        $settings['campaignid'] = '';
        $settings['affiliateid'] = '';
        $settings['ref1'] = '';
        $settings['ref2'] = '';
        $settings['ref3'] = '';
        $settings['ref4'] = '';        
        return $settings;
    }
   
    
    public function getName() {
        return 'Txprocess Txhandler';
    }
    
    public function getCardFields()
    {
        $fields = $this->getParameters();
        $fields['card_type'] = array('visa','mastercard');
        $fields['card_no'] = '';
        $fields['card_name'] = '';
        $fields['card_ccv'] ='';
        $fields['card_exp_month'] = '';
        $fields['card_exp_year'] = '';
        return $fields;
    }
   
    public function getBankFields()
    {
        $fields = $this->getParameters();              
        $fields['card_type'] = 'bank';
        $fields['routing_no'] ='';
        $fields['account_no'] = '';
        $fields['ach_type'] = '';
        $fields['account_name'] = '';
        $fields['regulation_e'] = '';
        $fields['class'] = '';
        $fields['receive_name'] = '';
        $fields['account_holder_type'] = '';
        return $fields;
    }
    
    /***
     * params passed by reference so that the value can be changed inside the function
     */
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
    public function purchase(array $parameters = array())
    {
        return $this->payment($parameters);
    }
    
    public function payment(array $parameters = array()) {
        $this->buildItems($parameters);
       
        $request = $this->createRequest('\Omnipay\Txprocess\Message\TxhandlerRequest', $parameters);

        return $request;
    }

    public function soappayment(array $parameters = array()) {
        $this->buildItems($parameters);
       
        $request = $this->createRequest('\Omnipay\Txprocess\Message\SoapRequest', $parameters);

        return $request;
    }
}
