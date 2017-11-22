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

function upgrade_module_3_0_5($object)
{
    // MasterPass
    $card = array(
        'type_payment' => 'WALLET',
        'type_card' => 'MASTERPASS',
        'label' => 'MasterPass',
        'active' => 0,
        'debit_expedition' => 0,
        'debit_immediat' => 1,
        'debit_differe' => 0,
        'remboursement' => 0,
        '3ds' => 0,
    );
    if (!Db::getInstance()->insert('paybox_card', $card)) {
        return false;
    }

    // Illicado
    $card = array(
        'type_payment' => 'PREPAYEE',
        'type_card' => 'ILLICADO',
        'label' => 'Illicado',
        'active' => 0,
        'debit_expedition' => 0,
        'debit_immediat' => 1,
        'debit_differe' => 0,
        'remboursement' => 0,
        '3ds' => 0,
    );
    if (!Db::getInstance()->insert('paybox_card', $card)) {
        return false;
    }

    // ANCV
    $card = array(
        'type_payment' => 'LIMONETIK',
        'type_card' => 'ANCV',
        'label' => 'ANCV',
        'active' => 0,
        'debit_expedition' => 0,
        'debit_immediat' => 1,
        'debit_differe' => 0,
        'remboursement' => 0,
        '3ds' => 0,
    );
    if (!Db::getInstance()->insert('paybox_card', $card)) {
        return false;
    }

    return true;
}
