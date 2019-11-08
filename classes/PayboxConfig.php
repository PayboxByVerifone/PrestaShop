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
 * Module configuration
 */
class PayboxConfig
{
    private $_defaults = array(
        'PAYBOX_3DS'                            => 1,
        'PAYBOX_3DS_MIN_AMOUNT'                 => '',
        'PAYBOX_MIN_AMOUNT'                 	=> '',
        'PAYBOX_MAX_AMOUNT'                 	=> '',
        'PAYBOX_DEBUG_MODE'                     => 'FALSE',
        'PAYBOX_HASH'                           => 'SHA512',
        'PAYBOX_IDENTIFIANT'                    => '3262411',
        'PAYBOX_KEYTEST'                        => '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF',
        'PAYBOX_PASS'                           => '1999888I',
        'PAYBOX_PRODUCTION'                     => 0,
        'PAYBOX_RANG'                           => '77',
        'PAYBOX_SITE'                           => '1999888',
        'PAYBOX_WEB_CASH_DIFF_DAY'              => 0,
        'PAYBOX_WEB_CASH_TYPE'                  => 'immediate',
        'PAYBOX_AUTORIZE_WALLET_CARD'           => 'CB,VISA,EUROCARD_MASTERCARD',
        'PAYBOX_WEB_CASH_ENABLE'                => 1,
        'PAYBOX_WEB_CASH_VALIDATION'            => '',
        'PAYBOX_WEB_CASH_STATE'                 => 2,
        'PAYBOX_WEB_CASH_DIRECT'                => 1,
        'PAYBOX_RECURRING_ENABLE'               => '',
        'PAYBOX_RECURRING_NUMBER'               => '0',
        'PAYBOX_RECURRING_PERIODICITY'          => '',
        'PAYBOX_RECURRING_ADVANCE'              => '',
        'PAYBOX_RECURRING_MIN_AMOUNT'           => '',
        'PAYBOX_RECURRING_MODE'                 => 'NX',
        'PAYBOX_LAST_STATE_NX'                  => 2,
        'PAYBOX_MIDDLE_STATE_NX'                => '',
        'PAYBOX_SUBSCRIBE_NUMBER'               => '0',
        'PAYBOX_SUBSCRIBE_PERIODICITY'          => '',
        'PAYBOX_SUBSCRIBE_DAY'                  => '1',
        'PAYBOX_SUBSCRIBE_DELAY'                => '0',
        'PAYBOX_DIRECT_ACTION'                  => 'N',
        'PAYBOX_DIRECT_VALIDATION'              => '',
        'PAYBOX_WALLET_ACTION'                  => 'N',
        'PAYBOX_WALLET_PERSONNAL_DATA'          => 0,
        'PAYBOX_DEFAULTCATEGORYID'              => '',
        'PAYBOX_WEB_CASH_ACTION'                => 'N',
        'PAYBOX_BO_ACTIONS'                     => 0,
        'PAYBOX_PAYMENT_DISPLAY'                => 0,
        'PAYBOX_DOC_URL'                        => 'http://www1.paybox.com/espace-integrateur-documentation/modules-by-paybox/',
        //'PAYBOX_CANCEL_URL'                     => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/validation.php',
        //'PAYBOX_NOTIFICATION_URL'               => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/validation.php',
        //'PAYBOX_RETURN_URL'                     => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/validation.php',
        //'PAYBOX_NOTIFICATION_NX_URL'            => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/validation_nx.php',
        //'PAYBOX_RETURN_NX_URL'                  => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/'.$this->name.'/validation_nx.php',
    );

    private $_urls = array(
        'system' => array(
            'test' => array(
                'https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi'
            ),
            'production' => array(
                'https://tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi',
                'https://tpeweb1.paybox.com/cgi/MYchoix_pagepaiement.cgi',
            ),
        ),
        'kwixo' => array(
            'test' => array(
                'https://preprod-tpeweb.paybox.com/php/'
            ),
            'production' => array(
                'https://tpeweb.paybox.com/php/',
                'https://tpeweb1.paybox.com/php/',
            ),
        ),
        'php' => array(
            'test' => array(
                'https://preprod-tpeweb.paybox.com/php/'
            ),
            'production' => array(
                'https://tpeweb.paybox.com/php/',
                'https://tpeweb1.paybox.com/php/',
            ),
        ),
        'mobile' => array(
            'test' => array(
                'https://preprod-tpeweb.paybox.com/cgi/MYframepagepaiement_ip.cgi'
            ),
            'production' => array(
                'https://tpeweb.paybox.com/cgi/MYframepagepaiement_ip.cgi',
                'https://tpeweb1.paybox.com/cgi/MYframepagepaiement_ip.cgi',
            ),
        ),
        'direct' => array(
            'test' => array(
                'https://preprod-ppps.paybox.com/PPPS.php'
            ),
            'production' => array(
                'https://ppps.paybox.com/PPPS.php',
                'https://ppps1.paybox.com/PPPS.php',
            ),
        ),
        'resabo' => array(
            'test' => array(
                'https://preprod-tpeweb.paybox.com/cgi-bin/ResAbon.cgi'
            ),
            'production' => array(
                'https://tpeweb.paybox.com/cgi-bin/ResAbon.cgi',
                'https://tpeweb1.paybox.com/cgi-bin/ResAbon.cgi',
            ),
        ),
    );

    // Remaining
    // 'PAYBOX_AUTORIZE_WALLET_CARD'           => 'CB,VISA,EUROCARD_MASTERCARD',
    // 'PAYBOX_WEB_CASH_ENABLE'                => 1,
    // 'PAYBOX_WEB_CASH_STATE'                 => 2,
    // 'PAYBOX_WEB_CASH_DIRECT'                => 1,
    // 'PAYBOX_RECURRING_ENABLE'               => '',
    // 'PAYBOX_RECURRING_NUMBER'               => '0',
    // 'PAYBOX_RECURRING_PERIODICITY'          => '',
    // 'PAYBOX_RECURRING_ADVANCE'              => '',
    // 'PAYBOX_RECURRING_MIN_AMOUNT'           => '',
    // 'PAYBOX_RECURRING_MODE'                 => 'NX',
    // 'PAYBOX_LAST_STATE_NX'                  => 2,
    // 'PAYBOX_MIDDLE_STATE_NX'                => '',
    // 'PAYBOX_SUBSCRIBE_NUMBER'               => '0',
    // 'PAYBOX_SUBSCRIBE_PERIODICITY'          => '',
    // 'PAYBOX_SUBSCRIBE_DAY'                  => '1',
    // 'PAYBOX_SUBSCRIBE_DELAY'                => '0',
    // 'PAYBOX_DIRECT_ACTION'                  => 'N',
    // 'PAYBOX_DIRECT_VALIDATION'              => '',
    // 'PAYBOX_WALLET_ACTION'                  => 'N',
    // 'PAYBOX_WALLET_PERSONNAL_DATA'          => 0,
    // 'PAYBOX_DEFAULTCATEGORYID'              => ''

    private function _get($name)
    {
        $value = Configuration::get($name);
        if (is_null($value)) {
            $value = false;
        }

        if (($value === false) || ($name=='PAYBOX_HASH' && $value === '') && isset($this->_defaults[$name])) {
            $value = $this->_defaults[$name];
        }

        return $value;
    }

    public function get3DSEnabled()
    {
        return $this->_get('PAYBOX_3DS');
    }

    public function get3DSAmount()
    {
        return $this->_get('PAYBOX_3DS_MIN_AMOUNT');
    }
    
    public function getMinAmount()
    {
        return $this->_get('PAYBOX_MIN_AMOUNT');
    }

    public function getMaxAmount()
    {
        return $this->_get('PAYBOX_MAX_AMOUNT');
    }

    public function getAllowedIps()
    {
        return array('194.2.122.158','195.25.7.166','195.101.99.76','194.2.122.190', '195.25.67.22');
    }

    public function getAutoCaptureState()
    {
        $value = $this->_get('PAYBOX_WEB_CASH_VALIDATION');
        return empty($value) ? -1 : intval($value);
    }

    public function getDebitType()
    {
        return $this->_get('PAYBOX_WEB_CASH_TYPE');
    }

    public function getDefaults()
    {
        return $this->_defaults;
    }

    public function getDelay()
    {
        return $this->_get('PAYBOX_WEB_CASH_DIFF_DAY');
    }

    public function getDeliveryDelay()
    {
        return $this->_get('PAYBOX_NBDELIVERYDAYS');
    }

    public function getHmacAlgo()
    {
        return $this->_get('PAYBOX_HASH');
    }

    public function getHmacKey()
    {
        $value = $this->_get('PAYBOX_KEYTEST');
        $crypt = new PayboxEncrypt();
        $value = $crypt->decrypt($value);

        return $value;
    }

    public function getIdentifier()
    {
        return $this->_get('PAYBOX_IDENTIFIANT');
    }

    public function getKwixoSuccessState()
    {
        return $this->_get('PAYBOX_KWIXO');
    }

    public function getPassword()
    {
        $value = $this->_get('PAYBOX_PASS');
        $crypt = new PayboxEncrypt();
        $value = $crypt->decrypt($value);

        return $value;
    }

    public function getRank()
    {
        return $this->_get('PAYBOX_RANG');
    }

    public function getRecurringMinimalAmount()
    {
        return floatval($this->_get('PAYBOX_RECURRING_MIN_AMOUNT'));
    }

    public function getSite()
    {
        return $this->_get('PAYBOX_SITE');
    }

    public function getSubscription()
    {
        return $this->_get('PAYBOX_WEB_CASH_DIRECT');
    }

    public function getSuccessState()
    {
        return $this->_get('PAYBOX_WEB_CASH_STATE');
    }

    protected function _getUrls($type)
    {
           $environment = $this->isProduction() ? 'production' : 'test';
        if (isset($this->_urls[$type][$environment])) {
            return $this->_urls[$type][$environment];
        }

        return array();
    }

    public function getDirectUrls()
    {
        return $this->_getUrls('direct');
    }

    public function getKwixoUrls()
    {
        return $this->_getUrls('kwixo');
    }

    public function getPHPUrls()
    {
        return $this->_getUrls('php');
    }

    public function getMobileUrls()
    {
        return $this->_getUrls('mobile');
    }

    public function getSystemUrls()
    {
        return $this->_getUrls('system');
    }

    public function getResAboUrls()
    {
        return $this->_getUrls('resabo');
    }

    public function isDebug()
    {
        return $this->_get('PAYBOX_DEBUG_MODE') == 1;
    }

    public function isRecurringEnabled()
    {
        return $this->_get('PAYBOX_RECURRING_ENABLE') == 1;
    }

    public function getDebitTypeForCard()
    {
        $type = $this->getDebitType();
        if ('immediate' === $type) {
            return 'immediat';
        } elseif ('delayed' === $type) {
            return 'differe';
        } elseif ('receive' === $type) {
            return 'expedition';
        } else {
            return $type;
        }
    }

    public function isRecurringCard($method)
    {
        if (in_array($method['type_card'], array('CB', 'VISA', 'EUROCARD_MASTERCARD', 'AMEX'))) {
            return true;
        }

        return false;
    }

    public function isProduction()
    {
        return $this->_get('PAYBOX_PRODUCTION') == 1;
    }
}
