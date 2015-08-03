<?php
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

if ($_POST) {
    //create gateway from the hidden variable value
    $gateway = Omnipay::create($_POST['gw']);
    //unset the gateway name from the list of params
    // unset($_POST['gw']);
    //copy post varaibles to params
    $params = $_POST;
    if ($_POST['gw'] == 'Txprocess_Txprocess' && $_POST['ptxid']) {

        $request = $gateway->fetchTransaction($params);
        $request->setPtxid($_POST['ptxid']);
        $response = $request->send();

    } elseif ($_POST['gw'] == 'Txprocess_Txprocess') {
        $response = $gateway->purchase($params)->send();

    }
    elseif($_POST['gw'] == 'Txprocess_Txhandler')
    {
         $response = $gateway->purchase($params)->send();
    }

    try {


        if ($response->isRedirect()) {

            $response->redirect();
        } else {
            // display error to customer
            exit($response->getData());
        }
    } catch (\Exception $e) {
        // internal error, log exception and display a generic message to the customer
        exit('Sorry, there was an error processing your payment. Please try again later.' . $e->getMessage());
    }
}
?>
<html>
    <head>Gateways</head>
    <body>
        <ul>
            <li><a href="index.php?gw=Txprocess_Txhandler&type=card">TxHandler(Card payment)</a>
            <li><a href="index.php?gw=Txprocess_Txhandler&type=bank">TxHandler(Bank payment)</a>
            <li><a href="index.php?gw=Txprocess_Txprocess">TxProcess Status Api(swagger)</a>
            <li><a href="index.php?gw=Txprocess_Txprocess&soap=1">TxProcess soap payment(swagger)</a>
<!--            <li><a href="index.php?gw=PayPal_Express">Paypal Express</a>
            <li><a href="index.php?gw=PayPal_Rest">Paypal Rest</a>-->
        </ul>
        <form name="postform" action="" method="post">

            <?php
            if ($_GET['gw']) {

                $gw = 'Txprocess_Txhandler';
                $gatewayname = $_GET['gw'];

                $gateway = Omnipay::create($gatewayname);
                $gateway->initialize();

                if (isset($_GET['type'])) {
                    $default = $gateway->getParameters();
                    if ($_GET['type'] == 'card') {
                        $fields = $gateway->getCardFields();
                    } elseif ($_GET['type'] == 'bank') {
                        $fields = $gateway->getBankFields();
                    }
                    $fields = array_merge($default, $fields);
                } elseif (isset($_GET['soap'])) {
                    $gw = 'Txprocess_Txprocess';
                    $fields = array(
                        'sid' => '1',
                        'rcode' => '9ff1a10f0a09b9388b5664f2dc1001e748c5b999',                        
                        'postback_url' => 'http://txprocess.geena.ipo-servers.net/secure/postback.php',
                        'timestamp' => '123456789',
                        'card_type' => 'visa',
                        'card_name' => 'Mike mustermann',
                        'card_no' => '4111111111111111',
                        'card_ccv' => '001',
                        'card_exp_month' => '05',
                        'card_exp_year' => '2018',
                        'firstname' => 'Mike',
                        'lastname' => 'Mustermann',
                        'email' => 'mike@mustermann.com',
                        'phone' => '1234567890',
                        'currency' => 'USD',
                        'address' => '12 Test Lane',
                        'suburb_city' => 'Testville',
                        'state' => 'TS',
                        'postcode' => '12345',
                        'country' => 'US',
                        'amount_shipping' => '0.02',
                        'amount_coupon' => '0.00',
                        'amount_tax' => '0.00',
                        'item_quantity[]' => '1',
                        'item_name[]' => 'apple',
                        'item_no[]' => 'a234',
                        'item_desc[]' => 'juicy green apple',
                        'item_amount_unit[]' => '5.20',
                        'tid' => '123',
                        'tx_action' => 'PAYMENT');
                } else {
                    $gw = 'Txprocess_Txprocess';
                    $fields = $gateway->getParameters();
                }
                foreach ($fields as $key => $val) {
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="gateway_<?= $key ?>"><?= $key ?></label>
                        <div class="controls">
                            <input type="text" name="<?= $key ?>" id="gateway_<?= $key ?>" value="<?= $val ?>" />
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <input type="hidden" name="gw"  value="<?= $gw ? $gw : '' ?>" />
            <div class="form-actions"><button type="submit" class="btn">Submit</button></div>
        </form>
    </body>
</html>

