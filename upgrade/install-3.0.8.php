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

function upgrade_module_3_0_8($object)
{
    // Champ pour stocker le type de paiement et le numéro de carte
    if (version_compare(_PS_VERSION_, '1.5', '>=')) {
        $sql = array();
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_card` ADD `mixte` INT(1) NULL DEFAULT 0 AFTER `remboursement`';
        $sql[] = 'UPDATE `'._DB_PREFIX_.'paybox_card` SET `mixte` = 1 WHERE (`type_card` = "ANCV")';
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_cart_locker` ADD `id_transaction` VARCHAR(20) NULL AFTER `id_cart`';
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_cart_locker` DROP PRIMARY KEY';
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_cart_locker` ADD PRIMARY KEY (`id_cart`, `id_transaction`)';

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }
    }

    return true;
}
