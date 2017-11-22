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
*  @version   3.0.2
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}
 
function upgrade_module_1_9_0($object)
{
    $column = '3ds';
    $result = Db::getInstance()->getRow('SELECT *
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = "'._DB_NAME_.'" AND TABLE_NAME = "'._DB_PREFIX_.'paybox_card" AND COLUMN_NAME = "'.$column.'"');
    if (false == $result) {
        if (Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'paybox_card` ADD `3ds` int(1) NULL')) {
            $cards = array();
            $cards[] = array('card' => 'CB', $column => 1);
            $cards[] = array('card' => 'VISA', $column => 1);
            $cards[] = array('card' => 'EUROCARD_MASTERCARD', $column => 1);
            $cards[] = array('card' => 'E_CARD', $column => 1);
            $cards[] = array('card' => 'MAESTRO', $column => 2);
            $cards[] = array('card' => 'AMEX', $column => 1);
            $cards[] = array('card' => 'PAYPAL', $column => 0);
            $cards[] = array('card' => 'LEETCHI', $column => 0);
            $cards[] = array('card' => 'COFINOGA', $column => 1);
            $cards[] = array('card' => 'AURORE', $column => 0);
            $cards[] = array('card' => 'UNEURO', $column => 0);
            $cards[] = array('card' => 'DINERS', $column => 0);
            $cards[] = array('card' => 'JCB', $column => 1);
            $cards[] = array('card' => 'BCMC', $column => 2);
            $cards[] = array('card' => 'IDEAL', $column => 0);
            $cards[] = array('card' => 'PAYBUTTING', $column => 0);
            $cards[] = array('card' => 'PSC', $column => 0);
            $cards[] = array('card' => 'CSHTKT', $column => 0);
            $cards[] = array('card' => 'PAYLIB', $column => 0);

            foreach ($cards as $card) {
                $sql = 'UPDATE `'._DB_PREFIX_.'paybox_card` SET `'.$column.'` = '.(int)$card[$column].' WHERE `type_card` = "'.$card['card'].'"';
                Db::getInstance()->execute($sql);
            }
        }
    }

    return true;
}
