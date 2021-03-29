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
*  @version   3.0.19
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_3_0_19($object)
{
    $sql = array();
    // Set 3DS to mandatory, when available
    $sql[] = 'UPDATE `'._DB_PREFIX_.'paybox_card` SET `3ds`="2" WHERE `3ds`="1"';
    // Add new 3ds_version column if not already exists
    $installer = new PayboxInstaller();
    if (!$installer->_sqlColumnExists(_DB_PREFIX_.'paybox_order', '3ds_version')) {
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_order` ADD COLUMN `3ds_version` varchar(255) NULL AFTER `secure`';
    }

    foreach ($sql as $query) {
        if (!Db::getInstance()->execute($query)) {
            return false;
        }
    }

    return true;
}
