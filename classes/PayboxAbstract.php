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
*  @version   2.0.0
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Base class for admin page helpers
 */
abstract class PayboxAbstract
{
    private $_module;

    // Retrocompatibility 1.4/1.5
    private function initContext()
    {
        if (class_exists('Context')) {
            $this->context = Context::getContext();
        } else {
            global $smarty, $cookie, $link;
            $this->context = new StdClass();
            $this->context->smarty = $smarty;
            $this->context->cookie = $cookie;
            $this->context->link = $link;
        }
    }
    public function __construct(Epayment $module)
    {
        $this->_module = $module;
        $this->initContext();
    }

    public function l($msg)
    {
        return $this->_module->l($msg, strtolower(get_class($this)));
    }

    public function getConfig()
    {
        return $this->getModule()->getConfig();
    }

    public function getHelper()
    {
        return $this->getModule()->getHelper();
    }

    public function getModule()
    {
        return $this->_module;
    }
}
