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
*  @version   3.0.8
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Base includes with override management
 */
$dir = dirname(__FILE__).'/';
if (!defined('_PS_OVERRIDE_DIR_')) {
    $overrideDir = _PS_ROOT_DIR_.'/override/';
} else {
    $overrideDir = _PS_OVERRIDE_DIR_;
}
$overrideDir .= 'modules/epayment/classes/';

$classes = array(
    'PayboxAbstract',
    'PayboxConfig',
    'PayboxController',
    'PayboxCurl',
    'PayboxEncrypt',
    'PayboxHelper',
    'PayboxInstaller',
    'PayboxKwixo',
    'PayboxDb',
);

foreach ($classes as $class) {
    if (file_exists($overrideDir.$class.'.php')) {
        require_once($overrideDir.$class.'.php');
    } else {
        require_once($dir.$class.'.php');
    }
}
