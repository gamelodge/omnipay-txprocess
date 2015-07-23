<?php


namespace Omnipay\Txprocess\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

use Omnipay\Common\Exception\RuntimeException;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response extends AbstractResponse
{
    protected $success;
    protected $errorMessage = '';

	public function __construct(RequestInterface $request, $data)
    {
    	parent::__construct($request, $data);

    	$dom = new \DOMDocument();
        $dom->loadHTML($data);

        $this->success = true;
        $inputs = $dom->getElementsByTagName('input');
        foreach($inputs as $input) {
            if($input->getAttribute('name') == 'status' && $input->getAttribute('value') == 'EXC') {
                $this->success = false;
            }
            else if($input->getAttribute('name') == 'error_msg') {
                $this->errorMessage = $input->getAttribute('value');
            }
        }
    }

    public function getRedirectResponse()
    {
        if(!$this->isRedirect())
            throw new RuntimeException('This response does not support redirection.');

        $output = $this->getData();
        return HttpResponse::create($output);
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function isRedirect()
    {
    	return $this->isSuccessful();
    }
}
