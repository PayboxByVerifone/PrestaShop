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
*  @version   3.0.13
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Curl helper (not fully used)
 */
class PayboxCurl
{
    private $_followRedirect = null;
    private $_timeout = null;
    private $_userAgent = null;

    public function get($url)
    {
        $ch = curl_init();
        
        if ($this->getFollowRedirect() === false) {
            curl_setopt($ch, CURLOPT_MAXREDIRS, 0);
        }
        if (!is_null($this->getTimeout())) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->getTimeout());
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->getTimeout());
        }
        if (!is_null($this->getUserAgent())) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->getUserAgent());
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/curl-ca-bundle.crt');
        
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        $parts = preg_split("#(\r\n\r\n|\r\r|\n\n)#", $result, 2);
        if (count($parts) != 2) {
            throw new Exception('Invalid data from remote server');
        }
        $headers = preg_split("#(\r\n|\r|\n)#", $parts[0]);
        $status = array_shift($headers);

        if (!preg_match('#^HTTP/(1\.0|1\.1|2) ([0-9]{3}) (.*)$#i', $status, $matches)) {
            throw new Exception('Invalid status returned by remote server');
        }
        $code = intval($matches[2]);
        $status = $matches[3];
        
        return array(
            'code' => $code,
            'status' => $status,
            'headers' => $headers,
            'body' => $parts[1]
        );
    }

    public function getFollowRedirect()
    {
        return $this->_followRedirect;
    }

    public function getTimeout()
    {
        return $this->_timeout;
    }

    public function getUserAgent()
    {
        return $this->_userAgent;
    }

    public function setFollowRedirect($followRedirect)
    {
        $this->_followRedirect = $followRedirect;
    }

    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
    }

    public function setUserAgent($userAgent)
    {
        $this->_userAgent = $userAgent;
    }
}
