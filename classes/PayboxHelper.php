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
*  @version   3.0.15
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Verifone e-commerce generic code
 */
class PayboxHelper extends PayboxAbstract
{
    private $_currencyDecimals = array(
        '008' => 2,
        '012' => 2,
        '032' => 2,
        '036' => 2,
        '044' => 2,
        '048' => 3,
        '050' => 2,
        '051' => 2,
        '052' => 2,
        '060' => 2,
        '064' => 2,
        '068' => 2,
        '072' => 2,
        '084' => 2,
        '090' => 2,
        '096' => 2,
        '104' => 2,
        '108' => 0,
        '116' => 2,
        '124' => 2,
        '132' => 2,
        '136' => 2,
        '144' => 2,
        '152' => 0,
        '156' => 2,
        '170' => 2,
        '174' => 0,
        '188' => 2,
        '191' => 2,
        '192' => 2,
        '203' => 2,
        '208' => 2,
        '214' => 2,
        '222' => 2,
        '230' => 2,
        '232' => 2,
        '238' => 2,
        '242' => 2,
        '262' => 0,
        '270' => 2,
        '292' => 2,
        '320' => 2,
        '324' => 0,
        '328' => 2,
        '332' => 2,
        '340' => 2,
        '344' => 2,
        '348' => 2,
        '352' => 0,
        '356' => 2,
        '360' => 2,
        '364' => 2,
        '368' => 3,
        '376' => 2,
        '388' => 2,
        '392' => 0,
        '398' => 2,
        '400' => 3,
        '404' => 2,
        '408' => 2,
        '410' => 0,
        '414' => 3,
        '417' => 2,
        '418' => 2,
        '422' => 2,
        '426' => 2,
        '428' => 2,
        '430' => 2,
        '434' => 3,
        '440' => 2,
        '446' => 2,
        '454' => 2,
        '458' => 2,
        '462' => 2,
        '478' => 2,
        '480' => 2,
        '484' => 2,
        '496' => 2,
        '498' => 2,
        '504' => 2,
        '504' => 2,
        '512' => 3,
        '516' => 2,
        '524' => 2,
        '532' => 2,
        '532' => 2,
        '533' => 2,
        '548' => 0,
        '554' => 2,
        '558' => 2,
        '566' => 2,
        '578' => 2,
        '586' => 2,
        '590' => 2,
        '598' => 2,
        '600' => 0,
        '604' => 2,
        '608' => 2,
        '634' => 2,
        '643' => 2,
        '646' => 0,
        '654' => 2,
        '678' => 2,
        '682' => 2,
        '690' => 2,
        '694' => 2,
        '702' => 2,
        '704' => 0,
        '706' => 2,
        '710' => 2,
        '728' => 2,
        '748' => 2,
        '752' => 2,
        '756' => 2,
        '760' => 2,
        '764' => 2,
        '776' => 2,
        '780' => 2,
        '784' => 2,
        '788' => 3,
        '800' => 2,
        '807' => 2,
        '818' => 2,
        '826' => 2,
        '834' => 2,
        '840' => 2,
        '858' => 2,
        '860' => 2,
        '882' => 2,
        '886' => 2,
        '901' => 2,
        '931' => 2,
        '932' => 2,
        '934' => 2,
        '936' => 2,
        '937' => 2,
        '938' => 2,
        '940' => 0,
        '941' => 2,
        '943' => 2,
        '944' => 2,
        '946' => 2,
        '947' => 2,
        '948' => 2,
        '949' => 2,
        '950' => 0,
        '951' => 2,
        '952' => 0,
        '953' => 0,
        '967' => 2,
        '968' => 2,
        '969' => 2,
        '970' => 2,
        '971' => 2,
        '972' => 2,
        '973' => 2,
        '974' => 0,
        '975' => 2,
        '976' => 2,
        '977' => 2,
        '978' => 2,
        '979' => 2,
        '980' => 2,
        '981' => 2,
        '984' => 2,
        '985' => 2,
        '986' => 2,
        '990' => 0,
        '997' => 2,
        '998' => 2,
    );

    private $_errorCode = array(
        '00000' => 'Successful operation',
        '00001' => 'Payment System not available',
        '00003' => 'Paybor error',
        '00004' => 'Card number or invalid cryptogram',
        '00006' => 'Access denied or invalid identification',
        '00008' => 'Invalid validity date',
        '00009' => 'Subscription creation failed',
        '00010' => 'Unknown currency',
        '00011' => 'Invalid amount',
        '00015' => 'Payment already done',
        '00016' => 'Existing subscriber',
        '00021' => 'Unauthorized card',
        '00029' => 'Invalid card',
        '00030' => 'Timeout',
        '00033' => 'Unauthorized IP country',
        '00040' => 'No 3D Secure',
    );

    private $_resultMapping = array(
        'M' => 'amount',
        'R' => 'reference',
        'T' => 'call',
        'A' => 'authorization',
        'B' => 'subscription',
        'C' => 'cardType',
        'D' => 'validity',
        'E' => 'error',
        'F' => '3ds',
        'G' => '3dsWarranty',
        'H' => 'imprint',
        'I' => 'ip',
        'J' => 'lastNumbers',
        'K' => 'sign',
        'N' => 'firstNumbers',
        'O' => '3dsInlistment',
        'o' => 'celetemType',
        'P' => 'paymentType',
        'Q' => 'time',
        'S' => 'transaction',
        'U' => 'subscriptionData',
        'W' => 'date',
        'Y' => 'country',
        'Z' => 'paymentIndex',
        'v' => '3dsVersion',
    );

    private $_transactionId = null;

    /**
     * 3.0.12 Compatibilité Curl 7.6.2
     *
     * @version  3.0.12
     *
     * @param  String  $url
     * @param  array $fields
     *
     * @return array()
     */
    private function _curl($url, $fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/curl-ca-bundle.crt');

        $result = curl_exec($ch);

        // TODO: Bad error management
        if (curl_errno($ch)) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $result = preg_split('/(\r\r|\n\n|\r\n\r\n)/', $result, 2);
        $data = count($result) == 2 ? $result[1] : null;
        $headers = explode("\r\n", $result[0]);
        if (preg_match('#^HTTP/(1\.0|1\.1|2) ([0-9]{3}) (.*)$#i', array_shift($headers), $matches)) {
            $code = intval($matches[2]);
            $status = trim($matches[3]);
        } else {
            $code = 999;
            $status = 'Error';
        }

        return array(
            'code' => $code,
            'status' => $status,
            'headers' => $headers,
            'data' => $data,
        );
    }

    /**
     * Direct call
     *
     * 3.0.11 CB55: rank on 3 positions
     *
     * @version  3.0.11
     *
     * @param  Order  $order
     * @param  string $type
     * @param  string $trxId
     * @param  string $callId
     * @param  string $amount
     * @param  string $cardType
     *
     * @return array()
     */
    private function _callDirect(Order $order, $type, $trxId, $callId, $amount, $cardType)
    {
        $customer = new Customer($order->id_customer);
        $currency = $this->getCurrency($order);

        $amountScale = $this->getCurrencyScale($order);
        $amount = floatval(str_replace(',', '.', $amount));
        $amount = round($amount * $amountScale);

        $version = '00103';
        if ((int) $this->getConfig()->getSubscription() == 2) {
            $version = '00104';
        }

        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $fields = array(
            'ACTIVITE' => '024',
            'VERSION' => $version,
            'DATEQ' => $now->format('dmYHis'),
            'DEVISE' => sprintf('%03d', $currency),
            'IDENTIFIANT' => $this->getConfig()->getIdentifier(),
            'MONTANT' => sprintf('%010d', $amount),
            'NUMAPPEL' => sprintf('%010d', $callId),
            'NUMQUESTION' => sprintf('%010d', time()),
            'NUMTRANS' => sprintf('%010d', $trxId),
            'RANG' => sprintf('%03d', $this->getConfig()->getRank()),
            'REFERENCE' => $order->id_cart.' - '.$this->getBillingName($customer),
            'SITE' => sprintf('%07d', $this->getConfig()->getSite()),
            'TYPE' => $type,
            'HASH' => strtoupper($this->getConfig()->getHmacAlgo()),
        );

        // Add ACQUEREUR for some cards
        switch ($cardType) {
            case 'PAYPAL':
                $fields['ACQUEREUR'] = 'PAYPAL';
                break;
        }

        // Sort parameters for simpler debug
        ksort($fields);

        // Sign values
        $fields['HMAC'] = $this->signValues($fields);

        $urls = $this->getConfig()->getDirectUrls();
        $url = $this->checkUrls($urls);

        $message = 'Order %d: call Verifone e-commerce - DEVISE=%s MONTANT=%s NUMAPPEL=%s NUMTRANS=%s TYPE=%s';
        $message = sprintf($message, $order->id, $fields['DEVISE'], $fields['MONTANT'], $fields['NUMAPPEL'], $fields['NUMTRANS'], $fields['TYPE']);
        $this->logDebug($message);
        $result = $this->_curl($url, $fields);

        $this->logDebug(sprintf('Order %d: Verifone e-commerce error code %d', $order->id, $result['code']));
        $this->logDebug(sprintf('Order %d: Verifone e-commerce data %s', $order->id, $result['data']));

        $data = array();
        parse_str($result['data'], $data);

        return $data;
    }

    /**
     * Make a capture using Direct method
     */
    private function _makeCapture(Order $order, $trxId, $callId, $amount, $cardType = null)
    {
        return $this->_callDirect($order, '00002', $trxId, $callId, $amount, $cardType);
    }

    /**
     * Make a new authorization using Direct method
     */
    // TODO ??? Same as _makeCapture ???
    private function _makeReauthorization(Order $order, $trxId, $callId, $amount, $cardType = null)
    {
        return $this->_callDirect($order, '00002', $trxId, $callId, $amount, $cardType);
    }

    /**
     * Make a refund using Direct method
     */
    private function _makeRefund(Order $order, $trxId, $callId, $amount, $cardType = null)
    {
        return $this->_callDirect($order, '00014', $trxId, $callId, $amount, $cardType);
    }

    /**
     * Add a private message to the order $order
     */
    public function addOrderNote(Order $order, $message)
    {
        $message = strip_tags($message, '<br>');
        if (!Validate::isCleanHtml($message)) {
            $message = $this->l('Payment message is not valid, please check your module.');
        }

        $msg = new Message();
        $msg->id_order = $order->id;
        $msg->message = $message;
        $msg->private = 1;
        $msg->add();
    }

    /**
     * [addOrderPayment description]
     *
     * 3.0.11 Check whether 'firstNumbers' and 'lastNumbers' variables are set
     *
     * @version  3.0.11
     * @param    Order  $order  [description]
     * @param    [type] $type   [description]
     * @param    [type] $params [description]
     * @param    [type] $method [description]
     */
    public function addOrderPayment(Order $order, $type, $params, $method)
    {
        if (method_exists('Cache', 'clean')) {
            Cache::clean('Cart::orderExists_'.$order->id_cart);
        }

        $cart = new Cart($order->id_cart);

        if (Validate::isLoadedObject($cart)) {
            $currency = new Currency(intval($cart->id_currency));

            $data = array(
                'id_order' => $order->id,
                'id_transaction' => $params['transaction'],
                'num_appel' => $params['call'],
                'ref_abo' => null,
                'payment_status' => $type,
                'amount' => $params['amount'],
                'initial_amount' => $params['amount'],
                'currency' => $currency->iso_code_num,
                'payment_by' => $method,
                'method' => Tools::substr($params['paymentType'], 0, 30),
                'carte_num' => (isset($params['firstNumbers']) ? $params['firstNumbers'] : '').(isset($params['lastNumbers']) ? 'XXXX'.$params['lastNumbers'] : ''),
                'carte' => $params['cardType'],
                'pays' => isset($params['country']) ? $params['country'] : '',
                'ip' => $params['ip'],
                'secure' => isset($params['3dsWarranty']) ? $params['3dsWarranty'] : 'N',
                '3ds_version' => isset($params['3dsVersion']) ? str_replace('3DSv', '', trim($params['3dsVersion'])) : '1.0.0',
                'date' => isset($params['date']) ? $params['date'] : 'N/A',
            );

            $db = new PayboxDb();
            if (!$db->insert('paybox_order', $data)) {
                $this->logError(sprintf('Unable to save order payment for order %d: %s', $order->id, $db->getMsgError()));
            }
        } else {
            $this->logFatal(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Unable to save order payment - Invalid Cart object'));
        }
    }

    public function addOrderRecurringDetails(Order $order, $amountPaid)
    {
        $data = array(
            'id_order' => $order->id,
            'status' => 'in progress',
            'number_term' => 2,
            'amount_paid' => $amountPaid,
        );

        $db = new PayboxDb();
        if (!$db->insert('paybox_recurring', $data)) {
            $this->logError(sprintf('Unable to save order payment for order %d: %s', $order->id, $db->getMsgError()));
        }
    }

    /**
     * [updatePSOrderPayment description]
     *
     * @since    3.0.11
     * @version  3.0.11
     *
     * @param    [type] $order  [description]
     * @param    [type] $params [description]
     * @return   [type]         [description]
     */
    public function updatePSOrderPayment($order, $params)
    {
        $isCreditCard = true;
        $orderPaymentCCFields = $this->getPSOrderPaymentCCFields();
        foreach ($orderPaymentCCFields as $orderPaymentCCField) {
            if (!isset($params[$orderPaymentCCField]) || empty($params[$orderPaymentCCField])) {
                $isCreditCard = false;
                break;
            }
        }

        if ($isCreditCard) {
            $orderPayment = $this->getPSOrderPayment($order->reference, $params['transaction']);
            if (false !== $orderPayment) {
                if ((isset($params['firstNumbers']) && isset($params['lastNumbers'])) && property_exists($orderPayment, 'card_number')) {
                    $orderPayment->card_number = Tools::substr($params['firstNumbers'].'XXXXXX'.$params['lastNumbers'], 0, 30);
                }
                if (isset($params['cardType']) && property_exists($orderPayment, 'card_brand')) {
                    $orderPayment->card_brand = $params['cardType'];
                }
                if (isset($params['validity']) && property_exists($orderPayment, 'card_expiration')) {
                    $orderPayment->card_expiration = $params['validity'];
                }

                if (!$orderPayment->update()) {
                    $this->logFatal(sprintf('Cart %d: Problem updating PrestaShop payment information', $cart->id));
                    return false;
                }
            } else {
                $this->logFatal(sprintf('Cart %d: No payment found to be updated', $order->id_cart));
                return false;
            }
        }

        return true;
    }

    /**
     * Retrieve PrestaShop OrderPayment from reference and transaction_id fields
     *
     * @since    3.0.11
     * @version  3.0.11
     *
     * @param    string $orderReference
     * @param    string $transactionId
     * @return   OrderPayment|false
     */
    public function getPSOrderPayment($orderReference, $transactionId)
    {
        $found = false;

        $orderPayments = OrderPayment::getByOrderReference($orderReference);
        if (0 != count($orderPayments)) {
            foreach ($orderPayments as $orderPayment) {
                if ($transactionId == $orderPayment->transaction_id) {
                    return $orderPayment;
                }
            }
        }

        return false;
    }

    /**
     * Retrieve PrestaShop OrderPayment from reference for mixed payments
     *
     * @since    3.0.11
     * @version  3.0.11
     *
     * @param    string $orderReference
     * @return   array|false
     */
    public function getPSOrderPaymentMixed($orderReference)
    {
        $orderPayments = OrderPayment::getByOrderReference($orderReference);
        if (1 < count($orderPayments)) {
            $payments = array();
            // First payment considered as the mixed one
            $payments['mixed'] = $orderPayments[0];
            // Second payment considered as the CC additional one
            $payments['cc'] = $orderPayments[1];

            return $payments;
        }

        return false;
    }


    /**
     * Get fields for CC information
     *
     * @since    3.0.11
     * @version  3.0.11
     *
     * @return   array
     */
    public function getPSOrderPaymentCCFields()
    {
        return array('firstNumbers', 'lastNumbers', 'cardType', 'validity');
    }

    /**
     * Create form data
     *
     * 3.0.11 CB55: rank on 3 positions
     *
     * @version  3.0.11
     *
     * @param Order  $order PrestaShop Order object
     * @param array  $card Card information
     * @param string $type one of standard ou threetime
     * @param array  $additionalParams
     * @return array
     */
    public function buildSystemParams(Cart $cart, array $card, $type, array $additionalParams = array())
    {
        $customer = new Customer($cart->id_customer);
        $reference = $cart->id.' - '.$this->getBillingName($customer);

        // Parameters
        $base = Tools::getHttpHost(true, false).__PS_BASE_URI__;
        $base .= 'index.php?fc=module&module=epayment&controller=validation&t=';
        if ($type == 'threetime') {
            $base .= '3';
        } else {
            $base .= 's';
        }
        $values = array(
            'PBX_ANNULE' => $base.'&a=c',
            'PBX_EFFECTUE' => $base.'&a=s',
            'PBX_REFUSE' => $base.'&a=f',
            'PBX_REPONDRE_A' => $base.'&a=i',
        );

        // Merchant information
        $values['PBX_SITE'] = $this->getConfig()->getSite();
        $values['PBX_RANG'] = substr(sprintf('%03d', $this->getConfig()->getRank()), -3);
        $values['PBX_IDENTIFIANT'] = $this->getConfig()->getIdentifier();

        // Card information
        $values['PBX_TYPEPAIEMENT'] = $card['type_payment'];
        $values['PBX_TYPECARTE'] = $card['type_card'];
        if ($card['type_payment'] == 'KWIXO') {
            $kwixo = new PayboxKwixo($this->getConfig());
            $values = $kwixo->buildKwixoParams($cart, $values);
        }

        // Order information
        $values['PBX_PORTEUR'] = $this->getBillingEmail($customer);
        $values['PBX_DEVISE'] = $this->getCurrency($cart);
        $values['PBX_CMD'] = $reference;

        // Module information
        $values['PBX_VERSION'] = 'PrestaShop_'.(defined('_PS_VERSION_') != null ? _PS_VERSION_ : '0').'-'.$this->getModule()->name.'_'.$this->getModule()->version;

        $orderAmount = floatval($cart->getOrderTotal());
        $amountScale = $this->_currencyDecimals[$values['PBX_DEVISE']];
        $amountScale = pow(10, $amountScale);
        if ($type == 'threetime') {
            $amounts = $this->computeThreetimePayments($orderAmount, $amountScale);
            foreach ($amounts as $k => $v) {
                $values[$k] = $v;
            }
        } else {
            $values['PBX_TOTAL'] = sprintf('%03d', round($orderAmount * $amountScale));
            switch ($this->getConfig()->getDebitType()) {
                case 'delayed':
                    if ($card['debit_differe']) {
                        $delay = $this->getConfig()->getDelay();
                        if ($delay < 1) {
                            $delay = 1;
                        } elseif ($delay > 7) {
                            $delay = 7;
                        }
                        $values['PBX_DIFF'] = sprintf('%02d', $delay);
                    }
                    break;
                case 'receive':
                    if ($card['debit_expedition']) {
                        $values['PBX_AUTOSEULE'] = 'O';
                    }
                    break;
            }
        }

        // Payment platform => PrestaShop
        $values['PBX_RETOUR'] = 'M:M;R:R;T:T;A:A;B:B;C:C;D:D;E:E;F:F;G:G;I:I;J:J;N:N;O:O;P:P;Q:Q;S:S;W:W;Y:Y;Z:Z;v:v;K:K';
        $values['PBX_RUF1'] = 'POST';

        // 3DSv2 parameters
        $values['PBX_SHOPPINGCART'] = $this->getXmlShoppingCartInformation($cart);
        $values['PBX_BILLING'] = $this->getXmlBillingInformation($cart);

        // Choose correct language
        $values['PBX_LANGUE'] = $this->getLanguage($cart);

        // Choose page format depending on browser/devise
        if ($this->isMobile()) {
            $values['PBX_SOURCE'] = 'XHTML';
        }

        // Misc.
        $values['PBX_TIME'] = date('c');
        $values['PBX_HASH'] = strtoupper($this->getConfig()->getHmacAlgo());

        // Card specific workaround
        if (($card['type_payment'] == 'LEETCHI') && ($card['type_card'] == 'LEETCHI')) {
            $values['PBX_EFFECTUE'] .= '&R='.urlencode($reference);
            $values['PBX_REFUSE'] .= '&R='.urlencode($reference);
        } elseif (($card['type_payment'] == 'PREPAYEE') && ($card['type_card'] == 'IDEAL')) {
            $s = '&C=IDEAL&P=PREPAYEE';
            $values['PBX_ANNULE'] .= $s;
            $values['PBX_EFFECTUE'] .= $s;
            $values['PBX_REFUSE'] .= $s;
            $values['PBX_REPONDRE_A'] .= $s;
        }

        // Adding additionnal informations
        $values = array_merge($values, $additionalParams);

        // Sort parameters for simpler debug
        ksort($values);

        // Sign values
        $values['PBX_HMAC'] = $this->signValues($values);

        return $values;
    }

    /**
     * Can order with id $orderId can be captured? It checks if Direct method
     * is enabled, if the order is handled and if the payment method
     * support the "paid on shipping" feature.
     * @param int $orderId
     * @return boolean
     */
    public function canCapture($orderId)
    {
        if (!$this->isDirectEnabled()) {
            return false;
        }

        $details = $this->getOrderDetails($orderId);
        if (empty($details)) {
            return false;
        }

        if ($details['payment_status'] != 'authorization') {
            return false;
        }

        $method = $this->getPaymentMethod($details['carte']);
        if (empty($method)) {
            return false;
        }

        return $method['debit_expedition'] == 1;
    }

    /**
     * Can order with id $orderId can be refunded? It checks if Direct method
     * is enabled, if the order is handled and if the payment method
     * support the "refund" feature.
     * @param int $orderId
     * @return boolean
     */
    public function canRefund($orderId)
    {
        if (!$this->isDirectEnabled()) {
            return false;
        }

        $details = $this->getOrderDetails($orderId);
        if (empty($details)) {
            return false;
        }

        // TODO: check this condition
        if (($details['payment_status'] != 'capture') && ($details['payment_status'] != 'canceled')) {
            return false;
        }

        $method = $this->getPaymentMethod($details['carte']);
        if (empty($method)) {
            return false;
        }

        return $method['remboursement'] == 1;
    }

    /**
     * is order with id $orderId recurring payment? It checks if Direct method
     * is enabled, if the order is handled by the module and if the payment method
     * support the "SystemRecurring" feature.
     * @param int $orderId
     * @return boolean
     */
    public function isRecurring($orderId)
    {
        if (!$this->isDirectEnabled()) {
            return false;
        }

        $details = $this->getOrderDetails($orderId);
        if (empty($details)) {
            return false;
        }

        if (($details['payment_by'] == 'PayboxSystemRecurring')) {
            return true;
        }

        return false;
    }

    public function checkUrls(array $urls)
    {
        // look for valid peer
        $client = new PayboxCurl();
        $client->setTimeout(5);
        $client->setUserAgent('Verifone e-commerce');
        $client->setFollowRedirect(false);
        $error = null;
        $this->logDebug(sprintf('URL to check %s', count($urls)));

        foreach ($urls as $url) {
            $testUrl = preg_replace('#^([a-zA-Z0-9]+://[^/]+)(/.*)?$#', '\1/load.html', $url);
            $this->logDebug(sprintf('Checking Verifone e-commerce URL %s', $testUrl));

            try {
                $response = $client->get($testUrl);
                if (!is_array($response)) {
                    $this->logDebug(sprintf('  Invalid response type %s', gettype($response)));
                } elseif ($response['code'] != 200) {
                    $this->logDebug(sprintf('  Invalid response code %s', $response['code']));
                } else {
                    $this->logDebug(sprintf('  Valid url found: %s', $url));
                    return $url;
                }
            } catch (Exception $e) {
                $this->logDebug(sprintf('  Exception %s: %s', get_class($e), $e->getMessage()));
                $error = $e;
            }
        }

        // Here, there's a problem
        $this->logDebug('No valid URL found!');
        throw new Exception($this->l('PaymentPlatform not available. Please try again later.'));
    }

    public function computeThreetimePayments($orderAmount, $amountScale)
    {
        $values = array();
        // Compute each payment amount
        $iterations = 3;
        $scaledOrderAmount = $orderAmount * $amountScale;
        $step = $scaledOrderAmount / $iterations;
        $nthStep = floor($step);
        $firstStep = round($scaledOrderAmount - ($nthStep * ($iterations - 1)));

        $values['PBX_TOTAL'] = sprintf('%03d', $firstStep);
        $values['PBX_2MONT1'] = sprintf('%03d', $nthStep);
        $values['PBX_2MONT2'] = sprintf('%03d', $nthStep);

        // Payment dates
        $now = new DateTime();
        $now->modify('1 month');
        $values['PBX_DATE1'] = $now->format('d/m/Y');
        $now->modify('1 month');
        $values['PBX_DATE2'] = $now->format('d/m/Y');


        // Force validity date of card
        $values['PBX_DATEVALMAX'] = $now->format('ym');
        return $values;
    }

    public function convertParams(array $params)
    {
        $result = array();
        foreach ($this->_resultMapping as $param => $key) {
            if (isset($params[$param])) {
                $result[$key] = utf8_encode($params[$param]);
            }
        }

        if (array_key_exists($this->_resultMapping["C"], $result)) {
            if ($result[$this->_resultMapping["C"]] == "Mastercard") {
                $result[$this->_resultMapping["C"]] = "EUROCARD_MASTERCARD";
            }
        }

        return $result;
    }

    public function deleteRecurringPayment(Order $order, array $details)
    {
        // Find URL
        $urls = $this->getConfig()->getResAboUrls();
        $url = $this->checkUrls($urls);

        // Call parameters
        $customer = new Customer($order->id_customer);
        $fields = array(
            'IDENTIFIANT' => $this->getConfig()->getIdentifier(),
            'MACH' => sprintf('%03d', $this->getConfig()->getRank()),
            'REFERENCE' => $order->id_cart.' - '.$this->getBillingName($customer),
            'SITE' => $this->getConfig()->getSite(),
            'TYPE' => '001',
            'VERSION' => '001',
        );

        // Call
        $result = $this->_curl($url, $fields);

        // Check answer
        if (($result['code'] != 200) || !preg_match('#^(.*&)?ACQ=OK(&.*)$#', $result['data'])) {
            $message = $this->l('Unable to cancel recurring payment.')."\r\n";
            $message .= $this->l('For more information logon to the PaymentPlatform Back-Office');
            $this->addOrderNote($order, $message);
            return false;
        }

        // Update details
        $sql = 'UPDATE `%spaybox_order` SET `payment_status` = "canceled"'
            .' WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $order->id);
        Db::getInstance()->execute($sql);

        // Add a note
        $message = $this->l('Recurring payment canceled.');
        $this->addOrderNote($order, $message);

        // Change state if needed
        if ($details['payment_status'] == 'capture') {
            $history = new OrderHistory();
            $history->id_order = (int)($order->id);
            $history->changeIdOrderState(Configuration::get('PAYBOX_STATE_MIN_CAPTURE'), $history->id_order);
            $history->addWithemail();
        }
        if ($details['payment_status'] == 'refundRecurring') {
            $history = new OrderHistory();
            $history->id_order = (int)($order->id);
            $history->changeIdOrderState(_PS_OS_REFUND_, $history->id_order);
            $history->addWithemail();
        }

        return true;
    }

    public function getAllPaymentMethods()
    {
        $sql = 'SELECT * FROM `%spaybox_card`';
        $sql = sprintf($sql, _DB_PREFIX_);

        return Db::getInstance()->executeS($sql);
    }

    public function getActivePaymentMethods($cart = null)
    {
        $allMethods = $this->getAllPaymentMethods();
        $methods = array();
        $amountScale = $this->_currencyDecimals[$this->getCurrency($cart)];
        $amountScale = pow(10, $amountScale);
        $max = round(floatval($this->getConfig()->getMaxAmount()));
        $max = intval(sprintf('%03d', $max*$amountScale));
        $min = round(floatval($this->getConfig()->getMinAmount()));
        $min = intval(sprintf('%03d', $min*$amountScale));
        $cartAmount = round(floatval($cart->getOrderTotal()));
        $cartAmount = intval(sprintf('%03d', $cartAmount * $amountScale));
        $limited = false;
        if ($min>0 || $max>0) {
            $limited = true;
        }
        foreach ($allMethods as $method) {
            $id = $method['id_card'];
            $active = Configuration::get('PAYBOX_CARD_ENABLED_'.$id);
            if ($limited && (($cartAmount >= $max) || ($cartAmount <= $min))) {
                $active = false;
            } else {
                $active = true;
            }
            $label = Configuration::get('PAYBOX_CARD_LABEL_'.$id);
            if ($active == false) {
                $method['active'] = 0;
            }
            if ($label !== false) {
                $method['label'] = $label;
            }
            if ($method['active'] == 1) {
                $methods[] = $method;
            }
        }

        return $methods;
    }

    public function getAmountPartialRefund($orderId)
    {
        $orderId = intval($orderId);
        if (empty($orderId)) {
            return false;
        }

        // [2.2.2] OrderSlip evolved: total_products_tax_incl & total_shipping_tax_incl appeared in PS 1.6.0.11, before amount contains products + shipping
        // $sql = 'SELECT SUM(`amount` + `shipping_cost_amount`) FROM `%sorder_slip` WHERE `id_order` = %d';
        // $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        // return Db::getInstance()->getValue($sql);
        $amount = 0;

        $sql = 'SELECT * FROM `%sorder_slip` WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        $result = Db::getInstance()->executeS($sql);
        foreach ($result as $row) {
            if (isset($row['total_products_tax_incl'])) {
                $amount += $row['total_products_tax_incl'];
            } else {
                $amount += $row['amount'];
            }
            if ($row['shipping_cost'] == 1) {
                if (isset($row['total_shipping_tax_incl'])) {
                    $amount += $row['total_shipping_tax_incl'];
                }
            }
        }

        return $amount;
    }

    public function getBillingEmail(Customer $customer)
    {
        return $customer->email;
    }

    public function getBillingName(Customer $customer)
    {
        $name = $customer->firstname.' '.$customer->lastname;
        $name = Tools::replaceAccentedChars($name);
        $name = str_replace(' - ', '-', $name);
        $name = trim(preg_replace('/[^-. a-zA-Z0-9]/', '', $name));
        return $name;
    }

    /**
     * Format a value to respect specific rules
     *
     * @param string $value
     * @param string $type
     * @param int $maxLength
     * @return string
     */
    protected function formatTextValue($value, $type, $maxLength = null)
    {
        /*
        AN : Alphanumerical without special characters
        ANP : Alphanumerical with spaces and special characters
        ANS : Alphanumerical with special characters
        N : Numerical only
        A : Alphabetic only
        */

        // Handle possible null values
        if (!is_string($value)) {
            $value = '';
        }

        switch ($type) {
            default:
            case 'AN':
                $value = Tools::replaceAccentedChars($value);
                break;
            case 'ANP':
                $value = Tools::replaceAccentedChars($value);
                $value = preg_replace('/[^-. a-zA-Z0-9]/', '', $value);
                break;
            case 'ANS':
                $value = Tools::replaceAccentedChars($value);
                break;
            case 'N':
                $value = preg_replace('/[^0-9.]/', '', $value);
                break;
            case 'A':
                $value = Tools::replaceAccentedChars($value);
                $value = preg_replace('/[^A-Za-z]/', '', $value);
                break;
        }
        // Remove carriage return characters
        $value = trim(preg_replace("/\r|\n/", '', $value));

        // Cut the string when needed
        if (!empty($maxLength) && is_numeric($maxLength) && $maxLength > 0) {
            if (function_exists('mb_strlen')) {
                if (mb_strlen($value) > $maxLength) {
                    $value = mb_substr($value, 0, $maxLength);
                }
            } elseif (strlen($value) > $maxLength) {
                $value = substr($value, 0, $maxLength);
            }
        }

        return trim($value);
    }

    /**
     * Import XML content as string and use DOMDocument / SimpleXML to validate, if available
     *
     * @param string $xml
     * @return string
     */
    protected function exportToXml($xml)
    {
        if (class_exists('DOMDocument')) {
            $doc = new DOMDocument();
            $doc->loadXML($xml);
            $xml = $doc->saveXML();
        } elseif (function_exists('simplexml_load_string')) {
            $xml = simplexml_load_string($xml)->asXml();
        }

        $xml = trim(preg_replace('/(\s*)(' . preg_quote('<?xml version="1.0" encoding="utf-8"?>') . ')(\s*)/', '$2', $xml));
        $xml = trim(preg_replace("/\r|\n/", '', $xml));

        return $xml;
    }

    /**
     * Generate XML value for PBX_BILLING parameter
     *
     * @param Cart $cart
     * @return string
     */
    public function getXmlBillingInformation(Cart $cart)
    {
        $billingAddress = new Address((int)$cart->id_address_invoice);
        $firstName = $this->formatTextValue($billingAddress->firstname, 'ANS', 22);
        $lastName = $this->formatTextValue($billingAddress->lastname, 'ANS', 22);
        $addressLine1 = $this->formatTextValue($billingAddress->address1, 'ANS', 50);
        $addressLine2 = $this->formatTextValue($billingAddress->address2, 'ANS', 50);
        $zipCode = $this->formatTextValue($billingAddress->postcode, 'ANS', 10);
        $city = $this->formatTextValue($billingAddress->city, 'ANS', 50);
        $isoCode = Country::getIsoById($billingAddress->id_country);

        $countryCode = (int)PayboxIso3166Country::getNumericCode($isoCode);
        $countryCodeFormat = '%03d';
        if (empty($countryCode)) {
            // Send empty string to CountryCode instead of 000
            $countryCodeFormat = '%s';
            $countryCode = '';
        }

        $mobilePhoneIntCode = PayboxIso3166Country::getPhoneCode($isoCode);
        $mobilePhoneNumber = $this->formatTextValue((!empty($billingAddress->phone_mobile) ? $billingAddress->phone_mobile : (!empty($billingAddress->phone) ? $billingAddress->phone : '')), 'N', 10);
        $mobilePhoneNumberFormat = '%d';
        if (empty($mobilePhoneIntCode) || empty($mobilePhoneNumber)) {
            // Send empty string to MobilePhone instead of 0
            $mobilePhoneNumberFormat = '%s';
            $mobilePhoneNumber = '';
        }
        $mobilePhone = sprintf('<CountryCodeMobilePhone>%s</CountryCodeMobilePhone><MobilePhone>' . $mobilePhoneNumberFormat . '</MobilePhone>', $mobilePhoneIntCode, $mobilePhoneNumber);

        $xml = sprintf(
            '<?xml version="1.0" encoding="utf-8"?><Billing><Address><FirstName>%s</FirstName><LastName>%s</LastName><Address1>%s</Address1><Address2>%s</Address2><ZipCode>%s</ZipCode><City>%s</City><CountryCode>' . $countryCodeFormat . '</CountryCode>' . $mobilePhone . '</Address></Billing>',
            $firstName,
            $lastName,
            $addressLine1,
            $addressLine2,
            $zipCode,
            $city,
            $countryCode
        );

        return $this->exportToXml($xml);
    }

    /**
     * Generate XML value for PBX_SHOPPINGCART parameter
     *
     * @param Cart $cart
     * @return string
     */
    public function getXmlShoppingCartInformation(Cart $cart)
    {
        $totalQuantity = 0;
        foreach ($cart->getProducts() as $item) {
            $totalQuantity += (int)$item['cart_quantity'];
        }
        // totalQuantity must be less or equal than 99
        $totalQuantity = max(1, min($totalQuantity, 99));

        return sprintf('<?xml version="1.0" encoding="utf-8"?><shoppingcart><total><totalQuantity>%d</totalQuantity></total></shoppingcart>', $totalQuantity);
    }

    public function getClientIp()
    {
        // return Tools::getRemoteAddr();
        // [2.2.2] Extended test on IPN IP in internal method
        $ipAddress = '';
        if ($_SERVER['HTTP_CLIENT_IP']) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_X_FORWARDED']) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif ($_SERVER['HTTP_FORWARDED_FOR']) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_FORWARDED']) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } elseif ($_SERVER['REMOTE_ADDR']) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipAddress = 'UNKNOWN';
        }

        return $ipAddress;
    }

    public function getCurrency($cartOrOrder)
    {
        $currency = new Currency($cartOrOrder->id_currency);
        return $currency->iso_code_num;
    }

    public function getCurrencyDecimals($cartOrOrder)
    {
        return $this->_currencyDecimals[$this->getCurrency($cartOrOrder)];
    }

    public function getCurrencyScale($cartOrOrder)
    {
        return pow(10, $this->getCurrencyDecimals($cartOrOrder));
    }

    public function getLanguage(Cart $cart)
    {
        $lang = Language::getIsoById($cart->id_lang);
        $languages = $this->getLanguages();
        if (!array_key_exists($lang, $languages)) {
            $lang = 'default';
        }
        return $languages[$lang];
    }

    public function getLanguages()
    {
        return array(
            'fr' => 'FRA',
            'es' => 'ESP',
            'it' => 'ITA',
            'de' => 'DEU',
            'nl' => 'NLD',
            'sv' => 'SWE',
            'pt' => 'PRT',
            'default' => 'GBR',
        );
    }

    public function getOrderDetails($orderId)
    {
        $orderId = intval($orderId);
        if (empty($orderId)) {
            return false;
        }

        $sql = 'SELECT * FROM `%spaybox_order` WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        return Db::getInstance()->getRow($sql);
    }

    public function getOrderPaymentBy($orderId)
    {
        $orderId = intval($orderId);
        if (empty($orderId)) {
            return false;
        }

        $sql = 'SELECT `payment_by` FROM `%spaybox_order` WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        return Db::getInstance()->getValue($sql);
    }

    public function getOrderRecurringDetails($orderId)
    {
        $orderId = intval($orderId);
        if (empty($orderId)) {
            return false;
        }

        $sql = 'SELECT * FROM `%spaybox_recurring` WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        return Db::getInstance()->getRow($sql);
    }

    public function getOrderTransactionId($orderId)
    {
        $orderId = intval($orderId);
        if (empty($orderId)) {
            return false;
        }

        $sql = 'SELECT `id_transaction` FROM `%spaybox_order` WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $orderId);
        return Db::getInstance()->getValue($sql);
    }

    public function getParams($logParams = false, $checkSign = true)
    {
        // Retrieves data
        $data = file_get_contents('php://input');
        if (empty($data)) {
            $data = $_SERVER['QUERY_STRING'];
        }
        if (empty($data)) {
            $message = 'An unexpected error in Verifone e-commerce call has occured: no parameters.';
            throw new Exception($this->l($message));
        }

        // Log params if needed
        if ($logParams) {
            $this->logDebug(sprintf('Call params: %s', $data));
        }

        // Check signature if needed
        if ($checkSign) {
            // Extract signature
            $matches = array();
            if (!preg_match('#^(.*)&K=(.*)$#', $data, $matches)) {
                $message = 'An unexpected error in Verifone e-commerce call has occured: missing signature.';
                throw new Exception($this->l($message));
            }

            // Check sign
            $signature = base64_decode(urldecode($matches[2]));
            $pubkey = file_get_contents(dirname(__FILE__).'/pubkey.pem');
            $res = (boolean) openssl_verify($matches[1], $signature, $pubkey);

            if (!$res) {
                if (preg_match('#^fc=module&module=epayment&controller=validation&t=[s3]&a=[cfrsij]&(.*)&K=(.*)$#', $data, $matches)) {
                    $signature = base64_decode(urldecode($matches[2]));
                    $res = (boolean) openssl_verify($matches[1], $signature, $pubkey);
                }

                if (preg_match('#^t=[s3]&a=[cfrsij]&C=IDEAL&P=PREPAYEE&(.*)&K=(.*)$#', $data, $matches)) {
                    $signature = base64_decode(urldecode($matches[2]));
                    $res = (boolean) openssl_verify($matches[1], $signature, $pubkey);
                }

                if (!$res) {
                    $message = 'An unexpected error in Verifone e-commerce call has occured: invalid signature.';
                    throw new Exception($this->l($message));
                }
            }
        }

        $rawParams = array();
        parse_str($data, $rawParams);

        // Decrypt params
        $params = $this->convertParams($rawParams);
        if (empty($params)) {
            $message = 'An unexpected error in Verifone e-commerce call has occured: no parameters.';
            throw new Exception($this->l($message));
        }

        return $params;
    }

    public function getPaymentMethod($cardType)
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `%spaybox_card` WHERE `type_card` = "%s"';
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $sql = sprintf($sql, _DB_PREFIX_, Tools::htmlentitiesUTF8($cardType));
        } else {
            $sql = sprintf($sql, _DB_PREFIX_, $db->escape($cardType));
        }
        $result = $db->executeS($sql);
        if (!empty($result)) {
            $result = $result[0];
        }
        return $result;
    }

    /**
     * Try to retrieve CardType from IPN params
     *
     * 3.0.11 Removed sleep, now on PayboxController
     *
     * @version  3.0.11
     * @param    string $cardType
     * @return   string Real payment method name
     */
    public function getRealPaymentMethodName($cardType)
    {
        // ANCV: additionnal CB payment received first
        if ('LIMOCB' == $cardType) {
            return 'ANCV';
        }

        return $cardType;
    }

    public function getPaymentMethodById($id)
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `%spaybox_card` WHERE `id_card` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, intval($id));
        $result = $db->executeS($sql);
        if (!empty($result)) {
            $result = $result[0];
        }
        return $result;
    }

    /**
     * Get all mixed payment methods
     *
     * @since    3.0.11
     * @version  3.0.11
     * @return   array()
     */
    public function getMixedPaymentMethods()
    {
        $db = Db::getInstance();
        $sql = 'SELECT `type_payment`, `type_card` FROM `%spaybox_card` WHERE `mixte` = 1';
        $sql = sprintf($sql, _DB_PREFIX_);

        $result = $db->executeS($sql);
        return $result;
    }

    public function isDirectEnabled()
    {
        return (Configuration::get('PAYBOX_WEB_CASH_DIRECT') == 1 || Configuration::get('PAYBOX_WEB_CASH_DIRECT') == 2);
    }

    public function isMobile()
    {
        // From http://detectmobilebrowsers.com/, regexp of 09/09/2013
        global $_SERVER;
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent)) {
            return true;
        }
        if (preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            return true;
        }
        return false;
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
     * [makeCaptureAll description]
     *
     * 3.0.11 Mixed payment method management
     *
     * @version  3.0.11
     * @param    Order   $order       [description]
     * @param    array   $details     [description]
     * @param    boolean $changestate [description]
     * @return   2 if call error, 1 if payment platform error, 0 if success
     */
    public function makeCaptureAll(Order $order, array $details, $changestate = true)
    {
        $this->logDebug(sprintf('Order %d: capture all', $order->id));

        // Retrieve method
        $method = $this->getHelper()->getPaymentMethod($details['carte']);

        // Check if mixed payment method
        $isMixed = false;
        if (1 == $method['mixte']) {
            // Get mixed OrderPayment
            $orderPayments = $this->getPSOrderPaymentMixed($order->reference);
            if (false != $orderPayments) {
                $isMixed = true;
            }
        }

        // Transaction informations
        $trxId = $details['id_transaction'];
        $callId = $details['num_appel'];


        // Refund partial (?)
        $partialRefund = 0;
        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $partialRefund = $this->getAmountPartialRefund($order->id);
            $this->logDebug(sprintf('Order %d: with partial refund of %f', $order->id, $partialRefund));
        }

        // Amount to capture
        $amountScale = $this->getCurrencyScale($order);
        $amount = ((int)$details['amount']) / $amountScale;

        // Test if final amount > initial or modified amount to capture the maximum available
        $orderTotal = $order->getOrdersTotalPaid();
        if ($orderTotal > $amount) {
            $initialAmount = ((int)$details['initial_amount']) / $amountScale;
            if ($orderTotal > $initialAmount) {
                if ($initialAmount > $amount) {
                    $amount = $initialAmount;
                }
            } else {
                $amount = $orderTotal;
            }
        }

        // Mixed payment: adapt transaction_id and amount
        if ($isMixed) {
            $trxId = $orderPayments['cc']->transaction_id;
            $amount -= $orderPayments['mixed']->amount;
        }

        // Capture there are more than 7 days?
        if (strtotime($order->date_add) <= mktime(23, 59, 59, date('m'), date('d') - 7, date('Y'))) {
            $this->logDebug(sprintf('Order %d: reauthorization required', $order->id));
            $response = $this->_makeReauthorization($order, $trxId, $callId, $amount - $partialRefund, $details['carte']);
        } else {
            $response = $this->_makeCapture($order, $trxId, $callId, $amount - $partialRefund, $details['carte']);
        }

        $currency = new Currency(intval($order->id_currency));

        if (empty($response)) {
            // Call error
            $this->logError(sprintf('Order %d: Verifone e-commerce call error', $order->id));
            return 2;
        } elseif ($response['CODEREPONSE'] != '00000') {
            // Payment platform error
            $this->logError(sprintf('Order %d: Verifone e-commerce returned an error of %s', $order->id, $response['CODEREPONSE']));
            $message = $this->l('Capture operation:').chr(10).chr(13);
            $message .= $this->l('Return code: error').' ['.$response['CODEREPONSE'].((!empty($response['COMMENTAIRE'])) ? ' - '.utf8_encode($response['COMMENTAIRE']) : '').']'.chr(10).chr(13);
            $message .= $this->l('Capture amount:').' '.($amount - $partialRefund).' '.$currency->sign.chr(10).chr(13);
            $message .= $this->l('For more information logon to the PaymentPlatform Back-Office');
            $this->addOrderNote($order, $message);

            return 1;
        }

        // Success
        $this->logError(sprintf('Order %d: Success of Verifone e-commerce call', $order->id));
        $message = $this->l('Capture operation:').chr(10).chr(13);
        $message .= $this->l('Return code: ok').chr(10).chr(13);
        $message .= $this->l('Ref.:').' '.$response['NUMTRANS'].chr(10).chr(13);
        $message .= $this->l('Capture amount:').' '.($amount - $partialRefund).' '.$currency->sign.chr(10).chr(13);
        $this->addOrderNote($order, $message);

        // Mixed payment: re-adapt amount to keep same based amount in Verifone e-commerce table
        if ($isMixed) {
            $amount += $orderPayments['mixed']->amount;
        }

        // Update database
        $sql = 'UPDATE `%spaybox_order` SET `payment_status` = "capture",'
            .' `id_transaction` = %d, `amount` = %d'
            .' WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, intval($response['NUMTRANS']), intval(strval(($amount - $partialRefund) * $amountScale)), $order->id);
        if (!Db::getInstance()->execute($sql)) {
            die(Tools::displayError('Error when updating Verifone e-commerce database'));
        }

        // Change order state if needed
        if ($partialRefund == 0) {
            $stateId = $this->getConfig()->getAutoCaptureState();
        } else {
            $stateId = Configuration::get('PAYBOX_STATE_MIN_CAPTURE');
        }

        if ($changestate) {
            if ($stateId != $order->current_state) {
                $history = new OrderHistory();
                $history->id_order = (int)($order->id);
                $history->changeIdOrderState($stateId, $history->id_order);
                $history->addWithemail();
            }
        }

        return 0;
    }

    /**
     * @return 3 if amount too high, 2 if call error, 1 if payment platform error, 0 if success
     */
    public function makeCaptureAmount(Order $order, array $details, $amount)
    {
        $this->logDebug(sprintf('Order %d: capture amount %s', $order->id, $amount));
        // Refund partial (?)
        $partialRefund = 0;
        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $this->logDebug(sprintf('Order %d: with partial refund of %f', $order->id, $partialRefund));
            $partialRefund = $this->getAmountPartialRefund($order->id);
        }

        // Amount to refund
        $amountScale = $this->getCurrencyScale($order);
        $amount = floatval(str_replace(',', '.', $amount));

        // Check if the amount is too high
        $check = $details['amount'] - $details['refund_amount'];
        $check -= round($amount * $amountScale);
        $check -= round($partialRefund * $amountScale);
        if ($check < 0) {
            $this->logDebug(sprintf('Order %d: amount too high', $order->id));
            return 3;
        }

        // Transaction informations
        $trxId = $details['id_transaction'];
        $callId = $details['num_appel'];

        $response = $this->_makeCapture($order, $trxId, $callId, $amount, $details['carte']);

        $currency = new Currency(intval($order->id_currency));

        if (empty($response)) {
            // Call error
            $this->logError(sprintf('Order %d: Verifone e-commerce call error', $order->id));
            return 2;
        } elseif ($response['CODEREPONSE'] != '00000') {
            // Payment platform error
            $this->logError(sprintf('Order %d: Verifone e-commerce returned an error of %s', $order->id, $response['CODEREPONSE']));
            $message = $this->l('PaymentPlatform capture amount:').chr(10).chr(13);
            $message .= $this->l('Return code: error').' ['.$response['CODEREPONSE'].((!empty($response['COMMENTAIRE'])) ? ' - '.utf8_encode($response['COMMENTAIRE']) : '').']'.chr(10).chr(13);
            $message .= $this->l('Capture amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
            $message .= $this->l('For more information logon to the PaymentPlatform Back-Office');
            $this->addOrderNote($order, $message);

            return 1;
        }

        $this->logError(sprintf('Order %d: Success of Verifone e-commerce call', $order->id));
        $message = $this->l('PaymentPlatform capture amount:').chr(10).chr(13);
        $message .= $this->l('Return code: ok').chr(10).chr(13);
        $message .= $this->l('Ref.:').' '.$response['NUMTRANS'].chr(10).chr(13);
        $message .= $this->l('Capture amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
        $this->addOrderNote($order, $message);

        // Update database
        $sql = 'UPDATE `%spaybox_order` SET `payment_status` = "capture",'
            .' `id_transaction` = %d, `amount` = %d'
            .' WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, intval($response['NUMTRANS']), round(($amount - $partialRefund) * $amountScale), $order->id);
        if (!Db::getInstance()->execute($sql)) {
            die(Tools::displayError('Error when updating database'));
        }

        // Change order state
        if ($details['amount'] - round($amount * $amountScale) == 0) {
            $stateId = $this->getConfig()->getAutoCaptureState();
        } else {
            $stateId = Configuration::get('PAYBOX_STATE_MIN_CAPTURE');
        }
        $history = new OrderHistory();
        $history->id_order = (int)($order->id);
        $history->changeIdOrderState($stateId, $history->id_order);
        $history->addWithemail();

        return 0;
    }

    /**
     * [makeRefundAll description]
     *
     * 3.0.11 Mixed payment method management
     *
     * @version  3.0.11
     * @param    Order   $order       [description]
     * @param    array   $details     [description]
     * @param    boolean $changestate [description]
     * @return   2 if call error, 1 if payment platform error, 0 if success
     */
    public function makeRefundAll(Order $order, array $details)
    {
        // Retrieve method
        $method = $this->getHelper()->getPaymentMethod($details['carte']);

        // Check if mixed payment method
        $isMixed = false;
        if (1 == $method['mixte']) {
            // Get mixed OrderPayment
            $orderPayments = $this->getPSOrderPaymentMixed($order->reference);
            if (false != $orderPayments) {
                $isMixed = true;
            }
        }

        // Transaction informations
        $trxId = $details['id_transaction'];
        $callId = $details['num_appel'];

        // Refund partial (?)
        $partialRefund = 0;
        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $partialRefund = $this->getAmountPartialRefund($order->id);
        }

        // Amount to refund
        $amountScale = $this->getCurrencyScale($order);
        // $amount = floatval($details['amount'] - $details['refund_amount']) / $amountScale;
        // $amount -= $partialRefund;
        $amount = floatval($details['amount']) / $amountScale;

        // Mixed payment: change transaction_id and amount
        if ($isMixed) {
            $trxId = $orderPayments['cc']->transaction_id;
            $details['id_transaction'] = $trxId;
            $amount -= $orderPayments['mixed']->amount;
        }

        // $response = $this->_makeRefund($order, $trxId, $callId, $amount, $details['carte']);
        $result = $this->processPaymentModified($order, $details, $amount);

        // If it's the full paid amount
        if ($order->total_paid_real == $amount) {
            $message = $this->l('PaymentPlatform Refund total:').chr(10).chr(13);
        } else {
            $message = $this->l('PaymentPlatform Refund partial:').chr(10).chr(13);
        }
        /*
        $currency = new Currency(intval($order->id_currency));

        // Call error
        if (empty($response)) {
            return 2;
        }

        // Payment platform error
        else if ($response['CODEREPONSE'] != '00000') {
            $message .= $this->l('Return code: error').chr(10).chr(13);
            $message .= $this->l('Refund amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
            $message .= $this->l('For more information logon to the PaymentPlatform Back-Office');
            $this->addOrderNote($order, $message);

            return 1;
        }

        // Success
        $message .= $this->l('Return code: ok').chr(10).chr(13);
        $message .= $this->l('Ref.:').$response['NUMTRANS'].chr(10).chr(13);
        $message .= $this->l('Refund amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
        $this->addOrderNote($order, $message);
        */
        $changeOrderState = false;
        if ($details['payment_by'] == 'PayboxSystemRecurring') {
            if ($details['payment_status'] == 'canceled') {
                $status = 'canceled/refundRecurring';
                $changeOrderState = true;
            } else {
                $status = 'refundRecurring';
                $changeOrderState = false;
            }
        } else {
            $status = 'Refunded';
            $changeOrderState = true;
        }
        /*
                // Update database
                $sql = 'UPDATE `%spaybox_order` SET `payment_status` = "%s",'
                    .' `id_transaction` = %d, `refund_amount` = refund_amount + %d'
                    .' WHERE `id_order` = %d';
                $sql = sprintf($sql, _DB_PREFIX_, $status, intval($response['NUMTRANS']),
                    round($amount * $amountScale), $order->id);
                if (!Db::getInstance()->execute($sql)) {
                    die(Tools::displayError('Error when updating database'));
                }
        */
        // Change state of order if needed
        if ($changeOrderState) {
            $history = new OrderHistory();
            $history->id_order = (int)($order->id);
            $history->changeIdOrderState(_PS_OS_REFUND_, $history->id_order);
            $history->addWithemail();
        }

        return $result;
    }

    /**
     * @return 3 if amount too high, 2 if call error, 1 if payment platform error, 0 if success
     */
    public function makeRefundAmount(Order $order, array $details, $amount)
    {
        // Refund partial (?)
        $partialRefund = 0;
        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $partialRefund = $this->getAmountPartialRefund($order->id);
        }

        // Amount to refund
        $amountScale = $this->getCurrencyScale($order);
        $amount = floatval(str_replace(',', '.', $amount));

        // Check if the refund amount is too high
        // $check = $details['amount'] - $details['refund_amount'];
        // $check -= round($amount * $amountScale);
        // $check -= round($partialRefund * $amountScale);
        // if ($check < 0) {
        //     return 3;
        // }

        // Transaction informations
        $trxId = $details['id_transaction'];
        $callId = $details['num_appel'];

        $response = $this->_makeRefund($order, $trxId, $callId, $amount, $details['carte']);

        $currency = new Currency(intval($order->id_currency));

        if (empty($response)) {
            // Call error
            return 2;
        } elseif ($response['CODEREPONSE'] != '00000') {
            // Payment platform error
            $message = $this->l('PaymentPlatform refund:').chr(10).chr(13);
            $message .= $this->l('Return code: error').' ['.$response['CODEREPONSE'].((!empty($response['COMMENTAIRE'])) ? ' - '.utf8_encode($response['COMMENTAIRE']) : '').']'.chr(10).chr(13);
            $message .= $this->l('Refund amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
            $message .= $this->l('For more information logon to the PaymentPlatform Back-Office');
            $this->addOrderNote($order, $message);

            return 1;
        }

        // Success
        $message = $this->l('PaymentPlatform refund:').chr(10).chr(13);
        $message .= $this->l('Return code: ok').chr(10).chr(13);
        $message .= $this->l('Ref.:').' '.$response['NUMTRANS'].chr(10).chr(13);
        $message .= $this->l('Refund amount:').' '.$amount.' '.$currency->sign.chr(10).chr(13);
        $this->addOrderNote($order, $message);

        $this->_transactionId = $response['NUMTRANS'];

        // Update database
        $sql = 'UPDATE `%spaybox_order` SET `refund_amount` = refund_amount + %d'
            .' WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, round($amount * $amountScale), $order->id);
        if (!Db::getInstance()->execute($sql)) {
            die(Tools::displayError('Error when updating database'));
        }

        return 0;
    }

    /**
     * Sign System message
     */
    public function signValues(array $values)
    {
        // Serialize values
        $params = array();
        foreach ($values as $name => $value) {
            $params[] = $name.'='.$value;
        }
        $query = implode('&', $params);

        // Prepare key
        $key = pack('H*', $this->getConfig()->getHmacKey());

        // Sign values
        $sign = hash_hmac($this->getConfig()->getHmacAlgo(), $query, $key);
        if ($sign === false) {
            $errorMsg = 'Unable to create hmac signature. Maybe a wrong configuration.';
            throw new Exception($this->l($errorMsg));
        }

        return strtoupper($sign);
    }

    public function toErrorMessage($code)
    {
        if (isset($this->_errorCode[$code])) {
            return $this->_errorCode[$code];
        }

        return 'Unknown error '.$code;
    }

    /**
     * Load order from the $token
     * @param string $token Token (@see tokenizeOrder)
     * @return Cart
     */
    public function untokenizeCart($token)
    {
        $parts = explode(' - ', $token, 2);
        if (count($parts) < 2) {
            $message = 'Invalid decrypted token "%s"';
            throw new Exception(sprintf($this->l($message), $token));
        }

        // Retrieves order
        $cart = new Cart($parts[0]);
        if (!Validate::isLoadedObject($cart)) {
            $message = 'Not existing cart id from decrypted token "%s"';
            throw new Exception(sprintf($this->l($message), $token));
        }

        $customer = new Customer($cart->id_customer);
        $name = $this->getBillingName($customer);
        if (($name != utf8_decode($parts[1])) && ($name != $parts[1])) {
            $message = 'Consistency error on descrypted token "%s"';
            throw new Exception(sprintf($this->l($message), $token));
        }

        return $cart;
    }

    public function updateOrderRecurringDetails(Order $order, $amountPaid, $numberTerm)
    {
        $db = Db::getInstance();
        $sql = 'UPDATE `%spaybox_recurring` SET `number_term` = %d, `amount_paid` = %d WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $numberTerm, $amountPaid, $order->id);
        $db->execute($sql);
        return true;
    }

    /**
     * Update amount informations for mixed payment methods
     * [3.0.8]
     */
    public function updateOrderMixedDetails(Order $order, $amountPaid)
    {
        $db = Db::getInstance();
        $sql = 'UPDATE `%spaybox_order` SET `initial_amount` = %d, `amount` = %d WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, $amountPaid, $amountPaid, $order->id);
        $db->execute($sql);
        return true;
    }

    /**
     * Process modification of amounts on an order
     *
     * 3.0.11 Mixed payment management (order / explicit amount)
     *
     * @version  3.0.11
     * @param    Order $order
     * @param    array $details
     * @param    float $explicitAmount
     * @param    bool $makeRefund
     * @return   array()
     */
    public function processPaymentModified($order, $details, $explicitAmount = 0, $makeRefund = true)
    {
        $actionType = 'order';
        $errors = array();

        $orderId = $order->id;
        $amountPaid = $order->total_paid_real;
        $amountOrder = $order->total_paid_tax_incl;
        $amountScale = $this->getCurrencyScale($order);
        $amountInitial = ((int)$details['initial_amount']) / $amountScale;
        $amountCurrent = ((int)$details['amount']) / $amountScale;

        // Allow refund on mixed payment method with allowed refundable amount
        /*
        // Retrieve method
        $method = $this->getHelper()->getPaymentMethod($details['carte']);

        // Check if mixed payment method
        $isMixed = false;
        if (1 == $method['mixte']) {
            // Get mixed OrderPayment
            $orderPayments = $this->getPSOrderPaymentMixed($order->reference);
            if (false != $orderPayments) {
                $isMixed = true;
            }
        }

        // Mixed payment: change amount and explicitAmount really available
        if ($isMixed) {
            $amountCurrent -= $orderPayments['mixed']->amount;
            if ($explicitAmount != 0 && $explicitAmount > $amountCurrent) {
                $explicitAmount = $amountCurrent;
            }
        }
        */

        if ($explicitAmount != 0) {
            $actionType = 'refund';
        }

        if (('order' == $actionType) && ($amountOrder > $amountPaid) && ($amountOrder > $amountInitial)) {
            return array(
                'status' => 0,
                'error' => 'New order amount exceeding the initial amount',
            );
        } elseif (($amountOrder < $amountPaid) || (($amountOrder > $amountPaid) && ($amountOrder < $amountInitial)) || ('refund' == $actionType)) {
            $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Order amount changed : '.$amountPaid.' => '.$amountOrder));

            // Currency informations
            $currency = new Currency(intval($order->id_currency));

            // Shipping capture
            if ($this->canCapture($orderId)) {
                // Refund
                $newAmount = $amountOrder;
                if ($amountOrder < $amountPaid) {
                    $operationAmount = ($amountPaid - $amountOrder) * -1;
                    $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Authorization - Refund: '.$operationAmount));
                } elseif ($amountOrder < $amountInitial) {
                    // Rebill
                    $operationAmount = $amountOrder - $amountCurrent;
                    $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Authorization - Rebill < initial: '.$operationAmount));
                } else {
                    $operationAmount = $amountInitial - $amountCurrent;
                    $newAmount = $amountInitial;
                    $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Authorization - Rebill > initial: '.$operationAmount.' - amount: '.$newAmount));

                    $order->total_paid_real = ($newAmount < 0) ? 0 : $newAmount;
                    $order->update();
                }

                return $this->updatePayments($order, $details, $newAmount, $operationAmount, $amountScale, $currency);
            } elseif (($order->hasBeenPaid() && $this->canRefund($orderId)) || $this->isRecurring($orderId)) {
                // Direct Debit or N Times
                // Only Refund allowed
                if (($amountOrder < $amountPaid) || ('refund' == $actionType)) {
                    if ('refund' == $actionType) {
                        $operationAmount = ($explicitAmount) * -1;
                        if ($this->isRecurring($orderId)) {
                            $newAmount = $amountCurrent + $operationAmount;
                            // $newAmount = 0;
                        } else {
                            // [2.2.2] Captured amount can be different from the order paid amount, use of the captured amount which is the official one
                            // $newAmount = $amountPaid + $operationAmount;
                            $newAmount = $amountCurrent + $operationAmount;
                        }
                        $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Refund action type: '.$operationAmount.' - amount: '.$newAmount));
                        // $order->total_paid_real = ($newAmount < 0) ? 0 : $newAmount;
                        // $order->update();
                    } else {
                        $operationAmount = ($amountPaid - $amountOrder) * -1;
                        // [2.2.2] Captured amount can be different from the order paid amount, use of the captured amount which is the official one
                        // $newAmount = $amountOrder;
                        $newAmount = $amountCurrent + $operationAmount;
                        $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Rebill < initial: '.$operationAmount.' - amount: '.$newAmount));
                    }

                    if ($makeRefund) {
                        $result = $this->makeRefundAmount($order, $details, ($operationAmount * -1));

                        switch ($result) {
                            case 1:
                                $errors[] = 'Refund request unsuccessful. Please see log message!';
                                return array(
                                    'status' => 0,
                                    'error' => $errors,
                                );

                            case 2:
                                $errors[] = 'Error when making refund request';
                                return array(
                                    'status' => 0,
                                    'error' => $errors,
                                );

                            case 3:
                                $errors[] = 'Error when making refund request';
                                return array(
                                    'status' => 0,
                                    'error' => $errors,
                                );
                        }
                    }

                    return $this->updatePayments($order, $details, $newAmount, $operationAmount, $amountScale, $currency);
                }
            }
        }

        return array(
            'status' => 1,
            'error' => 'Nothing to do',
        );
    }

    public function updatePayments($order, $details, $newAmount, $operationAmount, $amountScale, $currency)
    {
        $errors = array();

        // Update Payment
        $sql = 'UPDATE `%spaybox_order` SET `amount` = %d'
        . ' WHERE `id_order` = %d';
        $sql = sprintf($sql, _DB_PREFIX_, round($newAmount * $amountScale), $order->id);
        if (Db::getInstance()->execute($sql)) {
            if (version_compare(_PS_VERSION_, '1.5', '>=')) {
                // Save new Order total_paid_real to avoid loop (Order::update in Order::addOrderPayment function)
                // $order->total_paid_real = $newAmount;
                // $order->update();

                $orderPayments = OrderPayment::getByOrderReference($order->reference);
                if (count($orderPayments) != 0) {
                    /* [2.2.0] Refund is no longer attached to invoice (credit slip)
                    // Retrieve OrderInvoice
                    $orderInvoice = null;
                    if ($order->hasInvoice()) {
                        $invoices = $order->getInvoicesCollection();
                        foreach ($invoices as $invoice) {
                            $orderInvoice = $invoice;
                            break;
                        }
                    }
                    */
                    $orderInvoice = null;

                    // Negative order payment aren't allowed since PS 1.7.7+
                    $shouldCreateNegativeTransaction = (version_compare(_PS_VERSION_, '1.7.7.0', '>=') && $operationAmount >= 0) || version_compare(_PS_VERSION_, '1.7.7.0', '<');

                    $orderPaymentFound = false;
                    foreach ($orderPayments as $orderPayment) {
                        if ($orderPayment->transaction_id == $details['id_transaction']) {
                            // Retrieve potential new Transaction Id
                            $transactionId = $details['id_transaction'];
                            if (null !== $this->_transactionId) {
                                $transactionId = ltrim($this->_transactionId, '0');
                            }

                            $this->logDebug(sprintf('Cart %d: Order %d / %s%f %s %s', $order->id_cart, $order->id, 'Create OrderPayment of ', $operationAmount, 'for existing transaction', $transactionId));
                            if ($shouldCreateNegativeTransaction && !$order->addOrderPayment($operationAmount, $orderPayment->payment_method, $transactionId, $currency, null, $orderInvoice)) {
                                $errors[] = 'Problem creating new payment';

                                // Rollback
                                $sql = 'UPDATE `%spaybox_order` SET `amount` = %d'
                                . ' WHERE `id_order` = %d';
                                $sql = sprintf($sql, _DB_PREFIX_, round($order->total_paid_real * $amountScale), $order->id);

                                if (!Db::getInstance()->execute($sql)) {
                                    $errors[] = 'The initial payment amount in Verifone e-commerce could not be reset';
                                }
                                return array(
                                    'status' => 0,
                                    'error' => $errors,
                                );
                            }
                            $orderPaymentFound = true;
                            break;
                        }
                    }

                    if (!$orderPaymentFound) {
                        $transactionId = $details['id_transaction'];
                        if (null !== $this->_transactionId) {
                            $transactionId = ltrim($this->_transactionId, '0');
                        }

                        $this->logDebug(sprintf('Cart %d: Order %d / %s%f %s %s', $order->id_cart, $order->id, 'Create OrderPayment of ', $operationAmount, 'for new transaction', $transactionId));
                        if ($shouldCreateNegativeTransaction && !$order->addOrderPayment($operationAmount, $orderPayment->payment_method, $transactionId, $currency, null, $orderInvoice)) {
                            $errors[] = 'Problem creating new payment';

                            // Rollback
                            $sql = 'UPDATE `%spaybox_order` SET `amount` = %d'
                            . ' WHERE `id_order` = %d';
                            $sql = sprintf($sql, _DB_PREFIX_, round($order->total_paid_real * $amountScale), $order->id);

                            if (!Db::getInstance()->execute($sql)) {
                                $errors[] = 'The initial payment amount in Verifone e-commerce could not be reset';
                            }
                            return array(
                                'status' => 0,
                                'error' => $errors,
                            );
                        }
                    }
                }

                if ($order->hasInvoice()) {
                    $this->logDebug(sprintf('Cart %d: Order %d / %s', $order->id_cart, $order->id, 'Invoice modification'));
                    $order->setInvoice(true);
                }
            }

            return array(
                'status' => 1,
                'error' => $errors,
            );
        } else {
            $errors[] = 'The initial payment amount in Verifone e-commerce could not be reset';
            return array(
                'status' => 0,
                'error' => $errors,
            );
        }
    }

    /**
     * [getDisplayName description]
     *
     * 3.0.11 Add payment method label management (option 3 and 4)
     *
     * @version  3.0.11
     * @param    string $moduleName
     * @param    string $paymentMethod
     * @param    string|null $mode
     * @return   string
     */
    public function getDisplayName($moduleName, $paymentMethod, $mode = null)
    {
        $displayMode = Configuration::get('PAYBOX_PAYMENT_DISPLAY', 0);
        $name = $moduleName;

        if (1 == $displayMode) {
            $name = $paymentMethod;
        } elseif (2 == $displayMode) {
            $name = $moduleName.' ['.$paymentMethod.']';
        } elseif (3 == $displayMode || 4 == $displayMode) {
            $method = $this->getPaymentMethod($paymentMethod);
            if (false !== $method && isset($method['label'])) {
                $label = $method['label'];
            } else {
                $label = $paymentMethod;
            }

            if (3 == $displayMode) {
                $name = $label;
            } else {
                $name = $moduleName.' ['.$label.']';
            }
        }

        // Add n times payment information
        if (null != $mode) {
            $name .= ' (x'.$mode.')';
        }

        return $name;
    }

    /**
     * Check if cart & transaction already being processed
     * [3.0.8] Add transaction field
     */
    public function hasCartLocker($cartId, $transactionId)
    {
        $cartId = intval($cartId);
        if (empty($cartId)) {
            return false;
        }

        $sql = 'SELECT COUNT(*) FROM `%spaybox_cart_locker` WHERE `id_cart` = %d AND `id_transaction` = "%s"';
        $sql = sprintf($sql, _DB_PREFIX_, $cartId, $transactionId);

        $db = new PayboxDb();
        $value = $db->get($sql);

        if (0 < (int)$value) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create an history for cart & transaction being processed
     * [3.0.8] Add transaction field
     */
    public function createCartLocker($cartId, $transactionId)
    {
        $cartId = intval($cartId);
        if (empty($cartId)) {
            return false;
        }

        $data = array(
            'id_cart' => $cartId,
            'id_transaction' => $transactionId,
            'date_add' => date('Y-m-d H:i:s'),
        );

        $db = new PayboxDb();
        if (!$db->insert('paybox_cart_locker', $data)) {
            $this->logError(sprintf('Unable to save "CartLocker" for cart %d: %s', $cartId, $db->getMsgError()));

            return false;
        }

        return true;
    }

    public function isValidAmount($amount, $amountScale = 2)
    {
        if (preg_match('/^[0-9]{1,10}(\.[0-9]{1,'.$amountScale.'})?$/', $amount)) {
            if ($amount > 0) {
                return true;
            }
        }

        return false;
    }
}
