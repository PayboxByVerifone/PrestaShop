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
*  @version   3.0.6
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

if (version_compare(_PS_VERSION_, '1.6', '<')) {
    require_once dirname(__FILE__).'/PayboxHtmlWriter15.php';
} else {
    require_once dirname(__FILE__).'/PayboxHtmlWriter16.php';
}

/**
 * Base class for admin page helpers
 */
abstract class PayboxAbstractAdmin extends PayboxAbstract
{
    public function displayConfirmation($string)
    {
        return $this->getModule()->displayConfirmation($string);
    }

    public function getAdminUrl()
    {
        global $currentIndex;

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $link = $currentIndex;
        } else {
            $link = $this->context->link->getAdminLink('AdminModules', false);
        }

        return sprintf(
            '%s&configure=%s&token=%s',
            $link,
            $this->getModule()->name,
            Tools::getAdminTokenLite('AdminModules')
        );
    }

    public function getCssPath()
    {
        return $this->getModule()->getPath().'views/css/';
    }

    public function getImagePath()
    {
        return $this->getModule()->getImagePath();
    }
}
