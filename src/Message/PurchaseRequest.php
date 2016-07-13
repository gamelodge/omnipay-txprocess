<?php
/**
 *  Purchase Request
 */
 
namespace Omnipay\Txprocess\Message;

/**
 *  Purchase Request
 *
 * @see CardAbstractRequest
 */
class PurchaseRequest extends AbstractRequest
{
     
    /**
     * Get transaction endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getGatewayURI().'/secure/txHandler.php';
    }
    
     public function getData()
    {
        $items = $this->getParameter('items');
        $itemArray = [];

        $total = 0;
        foreach($items as $index => $item) {

            $total += $item['quantity'] * $item['amount_unit'];

            foreach($item as $k => $v) {
                $itemArray['item_' . $k . '[' . $index . ']'] = $v;
            }                
        }
        $total += $this->getAmountShipping() + $this->getAmountTax() - $this->getAmountCoupon();
        $this->setHash($this->generateHash($total));
            
        return array_merge($this->getParameters(), $itemArray);
    }
   
     public function generateHash($total)
    {
        return md5($this->getSid() . $this->getTimestamp() . number_format($total, 2, '.', '') . $this->getCurrency() . $this->getRcode());
    }

}
