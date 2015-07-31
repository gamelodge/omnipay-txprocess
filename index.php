<?php
require_once "vendor/autoload.php";
use Omnipay\Omnipay;

if($_POST)
{
    //create gateway from the hidden variable value
    $gateway = Omnipay::create($_POST['gw']);
    //unset the gateway name from the list of params
   // unset($_POST['gw']);
    //copy post varaibles to params
    $params = $_POST;
    if($_POST['gw'] == 'Txprocess_Txprocess')
    {
        
        $request = $gateway->fetchTransaction($params);
        $request->setPtxid($_POST['ptxid']);
        $response = $request->send();
        print_r($response->getData());
        exit;
    }
    
try {
    
    $response = $gateway->purchase($params)->send();

    if ($response->isRedirect()) {

            $response->redirect();
        }
     else {
        // display error to customer
        exit($response->getMessage());
    }
} catch (\Exception $e) {
    // internal error, log exception and display a generic message to the customer
    exit('Sorry, there was an error processing your payment. Please try again later.'.$e->getMessage());
}
    
}

?>
<html>
    <head>Gateways</head>
    <body>
        <ul>
            <li><a href="index.php?gw=Txprocess_Txhandler&type=card">TxHandler(Card payment)</a>
                <li><a href="index.php?gw=Txprocess_Txhandler&type=bank">TxHandler(Bank payment)</a>
            <li><a href="index.php?gw=Txprocess_Txprocess">TxProcess</a>
            <li><a href="index.php?gw=PayPal_Express">Paypal Express</a>
            <li><a href="index.php?gw=PayPal_Rest">Paypal Rest</a>
        </ul>
        <form name="postform" action="" method="post">
            <input type="hidden" name="gw"  value="<?=$_GET['gw']?$_GET['gw']:''?>" />
<?php
if ($_GET['gw']) {


    $gatewayname = $_GET['gw'];

    $gateway = Omnipay::create($gatewayname);
    $gateway->initialize();
   
    if(isset($_GET['type']))
    {
        if($_GET['type'] =='card')
        {
        $fields = $gateway->getCardFields();
        }
        elseif($_GET['type'] =='bank')
        {
            $fields = $gateway->getBankFields();
        }
         
    }
    else
    {
        $fields = $gateway->getParameters();
    }
    foreach ($fields as $key=>$val)
    {
        ?>
         <div class="control-group">
                <label class="control-label" for="gateway_<?=$key?>"><?=$key?></label>
                <div class="controls">
                    <input type="text" name="<?=$key?>" id="gateway_<?=$key?>" value="<?=$val?>" />
                </div>
            </div>
        <?php
    }
}
?>
             <div class="form-actions"><button type="submit" class="btn">Submit</button></div>
        </form>
    </body>
</html>

