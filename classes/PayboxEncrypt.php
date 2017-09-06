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
*  @version   3.0.5
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class PayboxEncrypt
{
    /**
     * You can change this method if you want to use another key than the
     * one provided by PrestaShop.
     * @return string Key used for encryption
     */
    private function _getKey()
    {
        // $key = Configuration::get('PS_NEWSLETTER_RAND');
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $key = _NEW_COOKIE_KEY_;
        } else {
            $key = _RIJNDAEL_KEY_;
        }

        return $key;
    }

    /**
     * Encrypt $data using 3DES
     * @param string $data The data to encrypt
     * @return string The result of encryption
     * @see Helper_Encrypt::_getKey()
     */
    public function encrypt($data)
    {
        if (empty($data)) {
            return '';
        }

        // First encode data to base64 (see end of descrypt)
        $data = base64_encode($data);

        // Prepare mcrypt
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');

        // Prepare key
        $key = $this->_getKey();
        $key = substr($key, 0, 24);
        while (strlen($key) < 24) {
            $key .= substr($key, 0, 24 - strlen($key));
        }

        // Init vector
        $size = mcrypt_enc_get_iv_size($td);
        $iv = mcrypt_create_iv($size, MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);

        // Encrypt
        $result = mcrypt_generic($td, $data);

        // Encode (to avoid data loose when saved to database or
        // any storage that does not support null chars)
        $result = base64_encode($result);

        return $result;
    }

    /**
     * Decrypt $data using 3DES
     * @param string $data The data to decrypt
     * @return string The result of decryption
     * @see Helper_Encrypt::_getKey()
     */
    public function decrypt($data)
    {
        if (empty($data)) {
            return '';
        }

        // First decode encrypted message (see end of encrypt)
        $data = base64_decode($data);

        // Prepare mcrypt
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');

        // Prepare key
        $key = $this->_getKey();
        $key = substr($key, 0, 24);
        while (strlen($key) < 24) {
            $key .= substr($key, 0, 24 - strlen($key));
        }

        // Init vector
        $size = mcrypt_enc_get_iv_size($td);
        $iv = mcrypt_create_iv($size, MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);

        // Decrypt
        $result = mdecrypt_generic($td, $data);

        // Remove any null char (data is base64 encoded so no data loose)
        $result = rtrim($result, "\0");

        // Decode data
        $result = base64_decode($result);

        return $result;
    }
}
