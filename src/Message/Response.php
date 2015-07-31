<?php


namespace Omnipay\Txprocess\Message;


Class Response extends \Omnipay\Common\Message\AbstractResponse
{
   
    public function isSuccessful()
    {
        if($this->data->status == 'OK')
            return true;
        else 
            return false;
    }

    public function getErrorMessage()
    {
        return $this->data->error_msg;
    }
    
    public function returnData()
    {
        return $this->data;
    }
    
}
