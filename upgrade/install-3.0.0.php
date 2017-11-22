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
*  @version   3.0.0
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_3_0_0($object)
{
    // Paylib
    $card = array(
        'type_payment' => 'WALLET',
        'type_card' => 'PAYLIB',
        'label' => 'Paylib',
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

    // Champ pour stocker le type de paiement et le numéro de carte
    if (version_compare(_PS_VERSION_, '1.5', '>=')) {
        $sql = array();
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_order` ADD `method` varchar(30) NULL';
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.'paybox_order` ADD `carte_num` varchar(30) NULL';

        foreach ($sql as $query) {
            if (!Db::getInstance()->Execute($query)) {
                return false;
            }
        }
    }

    // Capture manuelle
    $orderState = new OrderState();
    $orderState->name = array();
    foreach (Language::getLanguages() as $language) {
        if (strtolower($language['iso_code']) == 'fr') {
            $orderState->name[$language['id_lang']] = 'Capture manuelle du paiement';
        } else {
            $orderState->name[$language['id_lang']] = 'Manual capture of payment';
        }
    }
    $orderState->send_email = false;
    $orderState->color = '#DDEEFF';
    $orderState->hidden = true;
    $orderState->delivery = false;
    $orderState->logable = true;
    $orderState->invoice = true;
    if (version_compare(_PS_VERSION_, '1.5', '>=')) {
        $orderState->paid = true;
    }

    if ($orderState->add()) {
        $src = dirname(dirname(__FILE__)).'/img/orderState.gif';
        $dst = dirname(dirname(__FILE__)).'/../../img/os/'.((int)$orderState->id).'.gif';
        return copy($src, $dst);
    }

    return true;
}
