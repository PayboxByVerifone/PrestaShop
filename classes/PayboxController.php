<?php
/**
* Verifone e-commerce PrestaShop Module
*
* Feel free to contact Verifone e-commerce at support@paybox.com for any
* question.
*
* LICENSE: This source file is subject to the version 3.0 of the Open
* Software License (OSL-3.0) that is available through the world-wide-web
* at the following URI: http://opensource.org/licenses/OSL-3.0. If
* you did not receive a copy of the OSL-3.0 license and are unable
* to obtain it through the web, please send a note to
* support@paybox.com so we can mail you a copy immediately.
*
*  @category  Module / payments_gateways
*  @version   3.0.14
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Some sort of controller (not PrestaShop-like, liked to index.php)
 * The goal is to unify code between modules of different platforms
 */
class PayboxController extends PayboxAbstract
{

    public function __construct()
    {
        parent::__construct(new Epayment());
    }

    private function _redirectToCart()
    {
        $ctlr = Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order';
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $url = $this->context->link->getPageLink($ctlr.'.php', true);
        } else {
            $url = $this->getModule()->getContext()->link->getPageLink($ctlr);
        }
        Tools::redirectLink($url);
        die();
    }

    private function _redirectToPaymentChoice($reason = null)
    {
        $params = array('step' => 3, );

        if (!is_null($reason)) {
            $params['payboxReason'] = $reason;
        }

        $ctlr = Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order';

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $url = $this->context->link->getPageLink($ctlr.'.php', true);
        } else {
            $url = $this->getModule()->getContext()->link->getPageLink($ctlr, null, null, $params);
        }
        Tools::redirectLink($url);
        die();
    }

    public function cancelAction()
    {
        try {
            $params = $this->getHelper()->getParams();

            if ($params !== false) {
                $cart = $this->getHelper()->untokenizeCart($params['reference']);
                $message = sprintf('Cart %d: Payment was canceled by user on Verifone e-commerce payment page.', $cart->id);
                $this->logDebug($message);
                // TODO no way to associate this message to an order.
                //$message = $this->l('Payment canceled');
                //$this->getHelper()->addCartErrorMessage($message);
                $this->_redirectToPaymentChoice('cancel');
            }
        } catch (Exception $e) {
            // Ignore
        }

        $this->_redirectToCart();
    }

    public function defaultAction()
    {
        header('Status: 404 Not found', true, 404);
        die('<html><head><title>Not found</title><body><h1>Not found</h1><p>No page found</p></body></html>');
    }

    public function failureAction()
    {
        try {
            // Retrieves params
            $params = $this->getHelper()->getParams(false, false);

            if ($params !== false) {
                $cart = $this->getHelper()->untokenizeCart($params['reference']);
                $message = sprintf('Cart %d: Customer is back from Verifone e-commerce payment page. Payment refused by Verifone e-commerce (%d).', $cart->id, $params['error']);
                $this->logDebug($message);
                $this->_redirectToPaymentChoice('error');
            }
        } catch (Exception $e) {
            // Ignore
        }

        $this->_redirectToCart();
    }

    /**
     * IPN proccessing
     *
     * 3.0.11 Mixed payments: sleeps, check if mixed payment but not a mixed card_type (assume it is the additionnal payment)
     * 3.0.8  Mixed payment methods
     *
     * @version  3.0.11
     */
    public function ipnAction()
    {
        try {
            // Retrieves params
            $params = $this->getHelper()->getParams(true);
            if ($params === false) {
                return $this->defaultAction();
            }

            // Payment type
            $type = isset($_GET['t']) ? $_GET['t'] : 's';
            switch ($type) {
                case '3':
                    $type = 'threetime';
                    break;
                case 's':
                default:
                    $type = 'standard';
            }

            // [3.0.8] Try to retrieve Card from IPN params to process mixed payment methods
            if (array_key_exists('cardType', $params)) {

                // [3.0.11] Mixed payment fixes on IPN calls
                // ANCV: Sleep on CB for next payments
                if ('LIMOCB' == $params['cardType']) {
                    sleep(6);
                }

                $cardType = $this->getHelper()->getRealPaymentMethodName($params['cardType']);
                $method = $this->getHelper()->getPaymentMethod($cardType);
                if (false !== $method) {
                    if (isset($method['mixte'])) {
                        if (1 == $method['mixte']) {
                            $type = 'mixed';
                        }
                    }
                }
            }
            // [3.0.8] Try to check Z (paymentIndex) param for mixed payments
            if ('mixed' !== $type && array_key_exists('paymentIndex', $params)) {
                if (3 <= strlen($params['paymentIndex'])) {
                    // Z=1-2 (Index of payment - Count of payments)
                    $indexData = explode('-', $params['paymentIndex']);
                    if (1 < count($indexData)) {
                        // Check if several payments are expected
                        if ('1' <= $indexData[1]) {
                            $type = 'mixed';

                            // [3.0.11] Check if it is an additionnal payment to make it processed after the real mixed one
                            $mixedPaymentMethods = $this->getHelper()->getMixedPaymentMethods();
                            $isMainMixed = false;
                            if (false !== $mixedPaymentMethods) {
                                foreach ($mixedPaymentMethods as $mixedPaymentMethod) {
                                    if ($cardType == $mixedPaymentMethod['type_card']) {
                                        $isMainMixed = true;
                                        break;
                                    }
                                }
                            }

                            if (!$isMainMixed) {
                                sleep(10);
                            }
                        }
                    }
                }
            }

            // Load cart
            $cart = $this->getHelper()->untokenizeCart($params['reference']);

            /** [3.0.0] Removal of IPN IP control
            // IP not allowed
            $allowedIps = $this->getConfig()->getAllowedIps();
            $currentIp = $this->getHelper()->getClientIp();
            if (!in_array($currentIp, $allowedIps)) {
                $message = $this->l('IPN call from %s not allowed.');
                $message = sprintf($message, $currentIp);
                $this->logFatal(sprintf('Cart %d: (IPN) %s', $cart->id, $message));
                // TODO no way to associate this message to an order...
                throw new Exception($message);
            }
            */

            // Check required parameters
            $requiredParams = array('amount', 'transaction', 'error', 'reference', 'sign', 'date', 'time');
            foreach ($requiredParams as $requiredParam) {
                if (!isset($params[$requiredParam])) {
                    $message = sprintf($this->l('Missing %s parameter in Verifone e-commerce call'), $requiredParam);
                    $this->logFatal(sprintf('Cart %d: (IPN) %s', $cart->id, $message));
                    // TODO no way to associate this message to an order...
                    throw new Exception($message);
                }
            }

            // Fix context
            $this->context->cart = $cart;
            $this->context->customer = new Customer($cart->id_customer);
            $this->context->language = new Language($cart->id_lang);
            $this->context->shop = new Shop($cart->id_shop);
            $id_currency = (int)$cart->id_currency;
            $this->context->currency = new Currency($id_currency, null, $this->context->shop->id);

            if (in_array($params['error'], array('00000', '00200', '00201', '00300', '00301', '00302', '00303'))) {
                if ($this->getHelper()->hasCartLocker($cart->id, $params['transaction'])) {
                    $message = sprintf('Cart %d: (IPN) Cart already being validated as order with the transaction %s.', $cart->id, $params['transaction']);
                    $this->logDebug($message);
                } else {
                    if ($this->getHelper()->createCartLocker($cart->id, $params['transaction'])) {
                        // Payment success
                        switch ($type) {
                            case 'standard':
                                $this->getModule()->onStandardIPNSuccess($cart, $params);
                                break;

                            case 'mixed':
                                $this->getModule()->onMixedIPNSuccess($cart, $params);
                                break;

                            case 'threetime':
                                $this->getModule()->onThreetimeIPNSuccess($cart, $params);
                                break;

                            default:
                                $message = $this->l('Unexpected type %s');
                                $message = sprintf($message, $type);
                                // TODO no way to associate this message to an order...
                                throw new Exception($message);
                        }
                    } else {
                        $message = sprintf('Cart %d: (IPN) "CartLocker" creation failed, cart probably already being validated as order.', $cart->id);
                        $this->logDebug($message);
                    }
                }
            } else {
                // Payment refused
                $message = sprintf('Cart %d: (IPN) Payment was refused by Verifone e-commerce (%d).', $cart->id, $params['error']);
                $this->logDebug($message);
                // TODO no way to associate this message to an order...
            }
        } catch (Exception $e) {
            $message = sprintf('(IPN) Exception %s (%s %d).', $e->getMessage(), $e->getFile(), $e->getLine());
            $this->logFatal($message);
            header('Status: 500 Error', true, 500);
            echo $e->getMessage();
        }
    }

    public function redirectAction()
    {
        global $cart;

        if (!Validate::isLoadedObject($cart)) {
            throw new Exception($this->l('No cart found'));
        }
        if ($cart->orderExists()) {
            throw new Exception($this->l('Order already validated'));
        }

        // Find payment method
        $method = Tools::getValue('method');
        $method = $this->getHelper()->getPaymentMethodById($method);
        if (empty($method)) {
            throw new Exception('Invalid payment method');
        }

        // Build System params
        $type = 'standard';
        if (Tools::getValue('recurring') == '1') {
            $type = 'threetime';
        }
        $values = $this->getHelper()->buildSystemParams($cart, $method, $type);

        // Find good URLs
        if ($values['PBX_TYPEPAIEMENT'] == 'KWIXO') {
            $urls = $this->getConfig()->getKwixoUrls();
        } elseif ($values['PBX_TYPECARTE'] == 'ANCV') {
            $urls = $this->getConfig()->getPHPUrls();
        } elseif ($this->getHelper()->isMobile()) {
            $urls = $this->getConfig()->getMobileUrls();
        } else {
            $urls = $this->getConfig()->getSystemUrls();
        }

        // Build form
        $url = $this->getHelper()->checkUrls($urls);
        $debug = $this->getConfig()->isDebug();
        $inputType = $debug ? 'text' : 'hidden';
        ?>
        <!doctype html>
        <html>
            <body>
                <div style="width: 950px; margin: auto; margin-top: 20px; padding: 20px; background-color: #0089CF; font-family: Arial,sans-serif; font-size: 16px; font-weight: bold; color: white; text-align: center;">
                <form action="<?php echo Tools::htmlentitiesUTF8($url); ?>" method="post" name="PayboxSystem" enctype="application/x-www-form-urlencoded">
                    <p><center>
                        <?php
                        if ($debug) {
                            echo $this->l('This is a debug view. Click continue to be redirected to PaymentPlatform payment page.');
                        } else {
                            echo $this->l('You will be redirected to the PaymentPlatform payment page. If not, please use the button bellow.');
                        }
                        ?>
                    </center></p>
                <p><center><button style="margin-top: 35px; background-color: #ffffff; border: none; color: #0089CF; padding: 10px 38px; font-size: 16px; font-weight: 600; cursor: pointer;"><?php echo $this->l('Continue...'); ?></button></center></p>
            <?php
            foreach ($values as $name => $value) {
                $name = Tools::htmlentitiesUTF8($name);
                $value = Tools::htmlentitiesUTF8($value);
                if ($debug) {
                    echo '<p><label for="' . $name . '">' . $name . '</label>';
                }
                echo '<input type="' . $inputType . '" name="' . $name . '" value="' . $value . '"/>';
                if ($debug) {
                    echo '</p>';
                }
            }
            ?>
            </form>
        </div>
        <?php
        if (!$debug) {
            echo '<script>document.forms["PayboxSystem"].submit();</script>';
        }
        ?>
        </body>
        </html>
        <?php
        $message = sprintf('Cart %d: Redirecting customer to Verifone e-commerce (%s, %s).', $cart->id, $values['PBX_TYPEPAIEMENT'], $values['PBX_TYPECARTE']);
        $this->logDebug($message);
    }

    public function logDebug($message)
    {
        $this->getModule()->logDebug($message);
    }

    public function logWarning($message)
    {
        $this->getModule()->logDebug($message);
    }

    public function logError($message)
    {
        $this->getModule()->logDebug($message);
    }

    public function logFatal($message)
    {
        $this->getModule()->logDebug($message);
    }

    /**
     * Customer returns from payment platform
     * [3.0.8] Style / Loop 10 => 20
     */
    public function successAction()
    {
        try {
            // The loop is used to let the payment platform call the IPN URL so that the order
            // is validated. Without this feature, the user may return to the shop
            // before the order is validated and so no confirmation message can
            // be displayed.
            // The loop is, by default, configurer to 3 iterations of 1 seconde
            // each.
            $loop = 0;
            if (preg_match('#^(.*)&loop=([0-9]+)$#', $_SERVER['QUERY_STRING'], $matches)) {
                $_SERVER['QUERY_STRING'] = $matches[1];
                $loop = intval($matches[2]);
            }
            $params = $this->getHelper()->getParams(false, false);
            if ($params !== false) {
                $cart = $this->getHelper()->untokenizeCart($params['reference']);
                $orderId = Order::getOrderByCartId($cart->id);
                if (($orderId === false) || ($this->getHelper()->getOrderDetails($orderId) === false)) {
                    if ($loop < 20) {
                        $url = '?' . $_SERVER['QUERY_STRING'] . '&loop=' . ($loop + 1);
                        ?>
                        <!doctype html>
                        <html>
                            <head>
                                <meta http-equiv="refresh" content="1;url=<?php echo htmlentities($url); ?>"/>
                            </head>
                            <body>
                                <?php echo '<div style="width: 650px; margin: auto; margin-top: 20px; padding: 20px; background-color: #0089CF; font-family: Arial,sans-serif; font-size: 16px; font-weight: bold; color: white; text-align: center;">'.$this->l('Please wait while validating the order...').'</div>'; ?>
                            </body>
                        </html>
                        <?php
                        $message = sprintf('Cart %d: Customer is back from Verifone e-commerce payment page. Waiting order validation (loop %d).', $cart->id, $loop);
                        $this->logWarning($message);
                        die();
                    } else {
                        $message = sprintf('Cart %d: Customer is back from Verifone e-commerce payment page. Order not validated.', $cart->id);
                        $this->logFatal($message);
                        $this->_redirectToCart();
                    }
                }

                $message = sprintf('Cart %d: Customer is back from Verifone e-commerce payment page. Payment success.', $cart->id);
                $this->logDebug($message);
                // $message = $this->l('Customer is back from payment page.');
                // TODO no way to associate this message to an order...
                //RetroCompat 1.4
                if (version_compare(_PS_VERSION_, '1.5', '<')) {
                     $url = __PS_BASE_URI__.'order-confirmation.php?id_cart='.$cart->id.'&id_module='.$this->getModule()->id.'&key='.$cart->secure_key;
                } else {
                    $url = $this->getModule()->getContext()->link->getPageLink('order-confirmation', null, null, array(
                        'id_cart' => $cart->id,
                        'id_module' => $this->getModule()->id,
                        'key' => $cart->secure_key,
                    ));
                }

                Tools::redirectLink($url);
                die();
            }
        } catch (Exception $e) {
            // Ignore
            $this->logFatal($e->getMessage());
        }

        $this->_redirectToCart();
    }
}
