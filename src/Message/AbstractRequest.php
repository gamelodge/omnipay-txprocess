<?php

namespace Omnipay\Txprocess\Message;

//// TODO : don't forget campaignid[]
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'http://txprocess.aunn.dev.ipo-servers.net';

    public function getHttpMethod()
    {
        return 'POST';
    }

    /*public function sendData($data)
    {
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
        $httpResponse = $httpRequest
            ->setHeader('Authorization', 'Basic '.base64_encode($this->getApiKey().':'))
            ->send();

        return $this->response = new Response($this, $httpResponse->json());
    }*/

    public function sendData($data)
    {
//        echo $this->getEndpoint() . PHP_EOL;
        /*echo 'from sendData' . PHP_EOL;

        echo '<PRE>';
        print_r($data);
        echo '</pre>';*/

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data
        );

        $httpResponse = $httpRequest->send();

        //var_dump($httpResponse->getBody());
        //echo '<BR>';

        echo '<pre>';
        echo htmlspecialchars($httpResponse->getBody());
        echo '</pre>';
    }

    //// TODO : add throw when send incorrect item data
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

        $this->setHash($this->generateHash($total));
            
        return array_merge($this->getParameters(), $itemArray);
    }

    public function generateHash($total)
    {
        $ooo = [$this->getSid(), $this->getTimestamp(), number_format($total, 2, '.', ''), $this->getCurrency(), $this->getRcode()];

        echo '<pre>';
        echo $this->getCurrency();
        print_r($ooo);
        echo '</pre>';

        return md5($this->getSid() . $this->getTimestamp() . number_format($total, 2, '.', '') . $this->getCurrency() . $this->getRcode());
    }

    public function setSid($sid)
    {
        $this->setParameter('sid', $sid);
    }

    public function getSid()
    {
        return $this->getParameter('sid');
    }

    public function setTid($tid)
    {
        $this->setParameter('tid', $tid);
    }

    public function getTid()
    {
        return $this->getParameter('tid');
    }

    public function setRcode($rcode)
    {
        $this->setParameter('rcode', $rcode);
    }

    public function getRcode()
    {
        return $this->getParameter('rcode');
    }

    public function setPostbackUrl($postbackUrl)
    {
        $this->setParameter('postback_url', $postbackUrl);
    }

    public function getPostbackUrl()
    {
        return $this->getParameter('postback_url');
    }

    public function setRedirectUrl($RedirectUrl)
    {
        $this->setParameter('redirect_url', $RedirectUrl);
    }

    public function getRedirectUrl()
    {
        return $this->getParameter('redirect_url');
    }

    public function setHash($hash)
    {
        $this->setParameter('hash', $hash);
    }

    public function getHash()
    {
        return $this->getParameter('hash');
    }

    public function setTimestamp($timestamp)
    {
        $this->setParameter('timestamp', $timestamp);
    }

    public function getTimestamp()
    {
        return $this->getParameter('timestamp');
    }

    public function setCardType($cardType)
    {
        $this->setParameter('card_type', $cardType);
    }

    public function getCardType()
    {
        return $this->getParameter('card_type');
    }

    public function setCardName($cardName)
    {
        $this->setParameter('card_name', $cardName);
    }

    public function getCardName()
    {
        return $this->getParameter('card_name');
    }

    public function setCardNo($cardNo)
    {
        $this->setParameter('card_no', $cardNo);
    }

    public function getCardNo()
    {
        return $this->getParameter('card_no');
    }

    public function setCardCcv($cardCcv)
    {
        $this->setParameter('card_ccv', $cardCcv);
    }

    public function getCardCcv()
    {
        return $this->getParameter('card_ccv');
    }

    public function setCardExpMonth($cardExpMonth)
    {
        $this->setParameter('card_exp_month', $cardExpMonth);
    }

    public function getCardExpMonth()
    {
        return $this->getParameter('card_exp_month');
    }

    public function setCardExpYear($cardExpYear)
    {
        $this->setParameter('card_exp_year', $cardExpYear);
    }

    public function getCardExpYear()
    {
        return $this->getParameter('card_exp_year');
    }

    public function setBankName($bankName)
    {
        $this->setParameter('bank_name', $bankName);
    }

    public function getBankName()
    {
        return $this->getParameter('bank_name');
    }

    public function setBankPhone($bankPhone)
    {
        $this->setParameter('bank_phone', $bankPhone);
    }

    public function getBankPhone()
    {
        return $this->getParameter('bank_phone');
    }

    public function setUsername($username)
    {
        $this->setParameter('username', $username);
    }

    public function getUsername()
    {
        $this->getParameter('username');
    }

    public function setPassword($password)
    {
        $this->setParameter('password', $password);
    }

    public function getPassword()
    {
        $this->getParameter('password');
    }

    public function setFirstname($firstname)
    {
        $this->setParameter('firstname', $firstname);
    }

    public function getFirstname()
    {
        return $this->getParameter('firstname');
    }

    public function setLastname($lastname)
    {
        $this->setParameter('lastname', $lastname);
    }

    public function getLastname()
    {
        return $this->getParameter('lastname');
    }

    public function setPhone($phone)
    {
        $this->setParameter('phone', $phone);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setEmail($email)
    {
        $this->setParameter('email', $email);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setMobile($mobile)
    {
        $this->setParameter('mobile', $mobile);
    }

    public function getMobile()
    {
        return $this->getParameter('mobile');
    }

    public function setAddress($address)
    {
        $this->setParameter('address', $address);
    }

    public function getAddress()
    {
        return $this->getParameter('address');
    }

    public function setSuburbCity($suburbCity)
    {
        $this->setParameter('suburb_city', $suburbCity);
    }

    public function getSuburbCity()
    {
        $this->getParameter('suburb_city');
    }

    public function setState($state)
    {
        $this->setParameter('state', $state);
    }

    public function getState()
    {
        $this->getParameter('state');
    }

    public function setPostcode($postcode)
    {
        $this->setParameter('postcode', $postcode);
    }

    public function getPostcode()
    {
        return $this->getParameter('postcode');
    }

    public function setCountry($country)
    {
        $this->setParameter('country', $country);
    }

    public function getCountry()
    {
        $this->getParameter('country');
    }

    public function setShippingFirstname($shippingFirstname)
    {
        $this->setParameter('shipping_firstname', $shippingFirstname);
    }

    public function getShippingFirstname()
    {
        return $this->getParameter('shipping_firstname');
    }

    public function setShippingLastname($shippingLastname)
    {
        $this->setParameter('shipping_lastname', $shippingLastname);
    }

    public function getShippingLastname()
    {
        return $this->getParameter('shipping_lastname');
    }

    public function setShippingAddress($shippingAddress)
    {
        $this->setParameter('shipping_address', $shippingAddress);
    }

    public function getShippingAddress()
    {
        return $this->getParameter('shipping_address');
    }

    public function setShippingSuburbCity($shippingSuburbCity)
    {
        $this->setParameter('shipping_suburb_city', $shippingSuburbCity);
    }

    public function getShippingSuburbCity()
    {
        return $this->getParameter('shipping_suburb_city');
    }

    public function setShippingState($shippingState)
    {
        $this->setParameter('shipping_state', $shippingState);
    }

    public function getShippingState()
    {
        return $this->getParameter('shipping_state');
    }

    public function setShippingPostcode($shippingPostcode)
    {
        $this->setParameter('shipping_postcode', $shippingPostcode);
    }

    public function getShippingPostcode()
    {
        return $this->getParameter('shipping_postcode');
    }

    public function setShippingCountry($shippingCountry)
    {
        $this->setParameter('shipping_country', $shippingCountry);
    }

    public function getShippingCountry()
    {
        return $this->getParameter('shipping_country');
    }

    public function setCurrency($currency)
    {
        $this->setParameter('currency', $currency);
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function setAmountShipping($amountShipping)
    {
        $this->setParameter('amount_shipping', $amountShipping);
    }

    public function getAmountShipping()
    {
        return $this->getParameter('amount_shipping');
    }

    public function setAmountCoupon($amountCoupon)
    {
        $this->setParameter('amount_coupon', $amountCoupon);
    }

    public function getAmountCoupon()
    {
        return $this->getParameter('amount_coupon');
    }

    public function setAmountTax($amountTax)
    {
        $this->setParameter('amount_tax', $amountTax);
    }

    public function getAmountTax()
    {
        return $this->getParameter('amount_tax');
    }

    public function setAffiliateid($affiliateid)
    {
        $this->setParameter('affiliateid', $affiliateid);
    }

    public function getAffiliateid()
    {
        $this->getParameter('affiliateid');
    }

    public function setRef1($ref1)
    {
        $this->setParameter('ref1', $ref1);
    }

    public function getRef1()
    {
        $this->getParameter('ref1');
    }

    public function setRef2($ref2)
    {
        $this->setParameter('ref2', $ref2);
    }

    public function getRef2()
    {
        $this->getParameter('ref2');
    }

    public function setRef3($ref3)
    {
        $this->setParameter('ref3', $ref3);
    }

    public function getRef3()
    {
        $this->getParameter('ref3');
    }

    public function setRef4($ref4)
    {
        $this->setParameter('ref4', $ref4);
    }

    public function getRef4()
    {
        $this->getParameter('ref4');
    }

    public function setItems($items)
    {
        $this->setParameter('items', $items);
    }

    public function getItems()
    {
        return $this->getParameter('items');
    }
}
