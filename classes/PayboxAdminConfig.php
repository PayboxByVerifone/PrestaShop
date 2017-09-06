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

require_once dirname(__FILE__).'/PayboxAbstractAdmin.php';

/**
 * Admin configuration page helper
 */
class PayboxAdminConfig extends PayboxAbstractAdmin
{
    private $_newCardError = null;

    private function _writeLinks(array $links, PayboxHtmlWriter $w)
    {
        if (!empty($links)) {
            $w->rawRowStart();
            $w->html('<div class="pbx_links">');
            $w->html($this->l('See also:'));
            $a = array();
            foreach ($links as $url => $label) {
                $tpl = '<a href="#%s">%s</a>';
                $a[] = sprintf($tpl, $url, $label);
            }
            $w->html(' '.implode(', ', $a));
            $w->html('.</div>');
            $w->rawRowEnd();
        }
    }

    private function _writeConfigurationBlock(PayboxHtmlWriter $w)
    {
        global $cookie;

        $label = $this->l('Configuration');
        $w->blockStart('paybox_config_block', $label, $this->getImagePath().'server.png');

        $this->_writeLinks(array(
            'paybox_settings_block' => $this->l('Parameters'),
            'paybox_methods_block' => $this->l('Contracts'),
        ), $w);

        $states = OrderState::getOrderStates((int)($cookie->id_lang));

        // Environnement
        $w->formSelect(
            'PAYBOX_PRODUCTION',
            $this->l('Environment'),
            array(
                '0' => $this->l('Test'),
                '1' => $this->l('Production'),
            ),
            $this->getConfig()->isProduction() ? 1 : 0,
            null
        );
        $js = <<<EOF
$('#PAYBOX_PRODUCTION').change(function() {
    if (this.value == 1) {
        $('#PAYBOX_PRODUCTION_alert').hide('normal');
    }
    else {
        $('#PAYBOX_PRODUCTION_alert').show('normal');
    }
}).change();
EOF;
        $w->js($js);

        // Alert about test environment
        $w->formAlert(
            'PAYBOX_PRODUCTION_alert',
            $this->l('In test mode your payments will not be sent to the bank.'),
            !$this->getConfig()->isProduction()
        );

        // Warning about subscription
        //$w->rawRowStart();
        //$tpl = '<h3>%s</h3>';
        //$label = $this->l('Check your contracts before activating this mode of payment');
        //$w->html(sprintf($tpl, $label));
        //$w->rawRowEnd();

        // Subscription
        $w->formSelect(
            'PAYBOX_WEB_CASH_DIRECT',
            $this->l('Solution subscribed'),
            array(
                '0' => 'Pack Essentiel (Paybox System)',
                '1' => 'Pack Flexible (Paybox System + Direct)',
                '2' => 'Pack Plus (Paybox System + Direct plus)',
            ),
            $this->getConfig()->getSubscription(),
            null
        );
        $js = <<<EOF
$('#PAYBOX_WEB_CASH_DIRECT').change(function() {
    var div = $('#PAYBOX_PASS_container');
    var alert = $('#PAYBOX_PASS_alert');
    var opt = $('#PAYBOX_WEB_CASH_TYPE option[value=receive]');
    if (this.value == 1 || this.value == 2) {
        var npt = $('#PAYBOX_PASS');
        div.show('normal');
        if (npt.val().length >= 8) {
            alert.hide('normal');
        }
        else {
            alert.show('normal');
        }
        opt.removeAttr('disabled');
    }
    else {
        div.hide('normal');
        alert.hide('normal');
        opt.attr('disabled', 'true');
    }
}).change();
EOF;
        $w->js($js);

        // Warning about password
        $w->formAlert(
            'PAYBOX_PASS_alert',
            $this->l('To get your password, subscribe to the appropriate PaymentPlatform option.'),
            ($this->getConfig()->getSubscription() == '1' || $this->getConfig()->getSubscription() == '2') && (strlen($this->getConfig()->getPassword()) < 8)
        );

        // Password
        $w->formText(
            'PAYBOX_PASS',
            $this->l('Back-Office password'),
            $this->getConfig()->getPassword(),
            null,
            40,
            null,
            $this->getConfig()->getSubscription() == '1'
        );
        $js = <<<EOF
$('#PAYBOX_PASS').change(function() {
    var opt = $('#PAYBOX_WEB_CASH_DIRECT').val();
    if (opt == 1 || opt == 2) {
        var alert = $('#PAYBOX_PASS_alert');
        if (this.value.length >= 8) {
            alert.hide('normal');
        }
        else {
            alert.show('normal');
        }
    }
}).change();
EOF;
        $w->js($js);

        // Order state after payment
        $options = array();
        foreach ($states as $state) {
            $options[$state['id_order_state']] = Tools::stripslashes($state['name']);
        }
        $w->formSelect(
            'PAYBOX_WEB_CASH_STATE',
            $this->l('State after payment'),
            $options,
            $this->getConfig()->getSuccessState(),
            '2',
            $this->l('Order status if payment accepted')
        );

        // Debit type
        $w->formSelect(
            'PAYBOX_WEB_CASH_TYPE',
            $this->l('Type of payment'),
            array(
                'immediate'=>$this->l('Immediate'),
                'delayed'=>$this->l('Deferred'),
                'receive'=>$this->l('Debit on delivery')
            ),
            $this->getConfig()->getDebitType(),
            'immediate'
        );
        $js = <<<EOF
$('#PAYBOX_WEB_CASH_TYPE').change(function() {
    var delay = $('#PAYBOX_WEB_CASH_DIFF_DAY_container');
    var authState = $('#PAYBOX_WEB_CASH_VALIDATION_container');
    switch (this.value) {
        case 'delayed':
            authState.hide('normal');
            delay.show('normal');
            break;
        case 'immediate':
            authState.hide('normal');
            delay.hide('normal');
            break;
        case 'receive':
            authState.show('normal');
            delay.hide('normal');
            break;
    }
}).change();
EOF;
        $w->js($js);

        // Debit delay
        $w->formSelect(
            'PAYBOX_WEB_CASH_DIFF_DAY',
            $this->l('Differed payment day'),
            array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            $this->getConfig()->getDelay(),
            null,
            null,
            $this->getConfig()->getDebitType() == 'delayed'
        );

        // Order state after capture
        $options = array('-1' => $this->l('Manual capture'));
        foreach ($states as $state) {
            $options[$state['id_order_state']] = Tools::stripslashes($state['name']);
        }
        $w->formSelect(
            'PAYBOX_WEB_CASH_VALIDATION',
            $this->l('Status triggering capture'),
            $options,
            $this->getConfig()->getAutoCaptureState(),
            '0',
            $this->l('Automatic capture of payment when order state change to this state or only using the manual capture button.'),
            $this->getConfig()->getDebitType() == 'receive'
        );

        // 3-D Secure: enable/disable
        // [3.0.6] Always enabled, only amount configuration to disable 3DS
        $w->formSelect(
            'PAYBOX_3DS',
            $this->l('Activate 3D-Secure'),
            array(
                '0'=>$this->l('FALSE '),
                '1'=>$this->l('TRUE '),
            ),
            // $this->getConfig()->get3DSEnabled(),
            '1',
            '0',
            $this->l('Warning : your bank may enforce 3D Secure. Make sure your set up is coherent with your Bank, PaymentPlatform and Prestashop'),
            false
        );
        $js = <<<EOF
$('#PAYBOX_3DS').change(function() {
    var alert = $('#PAYBOX_3DS_alert');
    var npt = $('#PAYBOX_3DS_MIN_AMOUNT_container');
    if (this.value == 1) {
        alert.show('normal');
        npt.show('normal');
    }
    else {
        alert.hide('normal');
        npt.hide('normal');
    }
}).change();

EOF;
        $w->js($js);

        // 3-D Secure: alert
        $w->formAlert(
            'PAYBOX_3DS_alert',
            // $this->l('Make sure that the contract signed with your bank allows 3D-Secure before proceeding with setup.'),
            $this->l('Warning : your bank may enforce 3D Secure. Make sure your set up is coherent with your Bank, PaymentPlatform and Prestashop'),
            $this->getConfig()->get3DSEnabled() == '1',
            '-60px'
        );

        // 3-D Secure: minimal amount
        $w->formText(
            'PAYBOX_3DS_MIN_AMOUNT',
            $this->l('Minimum amount order 3D-Secure'),
            $this->getConfig()->get3DSAmount(),
            $this->l('Leave empty for all payments using the 3D-Secure authentication'),
            3,
            null,
            $this->getConfig()->get3DSEnabled() == '1'
        );

        // Threetime: enable/disable
        $w->formSelect(
            'PAYBOX_RECURRING_ENABLE',
            $this->l('web payment in three times'),
            array(
                '0'=>$this->l('FALSE '),
                '1'=>$this->l('TRUE '),
            ),
            $this->getConfig()->isRecurringEnabled() ? 1 : 0,
            null
        );
        $js = <<<EOF
$('#PAYBOX_RECURRING_ENABLE').change(function() {
    var alert = $('#PAYBOX_RECURRING_ENABLE_alert');
    var elm1 = $('#PAYBOX_RECURRING_MIN_AMOUNT_container');
    var elm2 = $('#PAYBOX_MIDDLE_STATE_NX_container');
    var elm3 = $('#PAYBOX_LAST_STATE_NX_container');
    if (this.value == 1) {
        alert.show('normal');
        elm1.show('normal');
        elm2.show('normal');
        elm3.show('normal');
    }
    else {
        alert.hide('normal');
        elm1.hide('normal');
        elm2.hide('normal');
        elm3.hide('normal');
    }
}).change();
EOF;
        $w->js($js);

        // Threetime: alert
        $w->formAlert(
            'PAYBOX_RECURRING_ENABLE_alert',
            $this->l('Make sure the solution purchased prior to setting.'),
            $this->getConfig()->isRecurringEnabled()
        );

        // Threetime: minimal amount
        $w->formText(
            'PAYBOX_RECURRING_MIN_AMOUNT',
            $this->l('Minimum amount order paid in three times'),
            $this->getConfig()->getRecurringMinimalAmount(),
            $this->l('Leave blank if there is no minimum order'),
            3,
            null,
            $this->getConfig()->isRecurringEnabled()
        );

        // Threetime: order status after first and second payments
        $options = array();
        foreach ($states as $state) {
            $options[$state['id_order_state']] = stripslashes($state['name']);
        }
        $w->formSelect(
            'PAYBOX_MIDDLE_STATE_NX',
            $this->l('State after payment 1 and 2'),
            $options,
            Configuration::get('PAYBOX_MIDDLE_STATE_NX'),
            Configuration::get('PAYBOX_ID_ORDER_STATE_NX'),
            null,
            $this->getConfig()->isRecurringEnabled()
        );

        // Threetime: order status after final payment
        // We reuse options array here
        $w->formSelect(
            'PAYBOX_LAST_STATE_NX',
            $this->l('State after last payment'),
            $options,
            Configuration::get('PAYBOX_LAST_STATE_NX'),
            '2',
            null,
            $this->getConfig()->isRecurringEnabled()
        );

        // [3.0.4] Display Payment method
        $optionsDisplay = array(
            0 => $this->l('Payment module (ex: ').'Verifone e-commerce)',
            1 => $this->l('Payment method (ex: ').'VISA)',
            2 => $this->l('Payment module and method (ex: ').'Verifone e-commerce [VISA])',
        );
        $w->formSelect(
            'PAYBOX_PAYMENT_DISPLAY',
            $this->l('Payment method display'),
            $optionsDisplay,
            Configuration::get('PAYBOX_PAYMENT_DISPLAY'),
            '0',
            null,
            true,
            false
        );

        // [3.0.4] Back Office actions
        $w->formSelect(
            'PAYBOX_BO_ACTIONS',
            $this->l('Automation of Back Office actions'),
            array(
                '0'=>$this->l('FALSE '),
                '1'=>$this->l('TRUE '),
            ),
            Configuration::get('PAYBOX_BO_ACTIONS'),
            '1',
            null,
            true,
            false
        );

        // Alert about test environment
        $w->formAlert(
            'PAYBOX_BO_ACTIONS_alert',
            $this->l('Automation of Back Office actions will trigger refunds for every modification of an order amount (production cancellation, product price modification...).')
        );

        // Save button
        $w->formButton(null, $this->l('Save settings'));

        $w->blockEnd();
    }

    private function _writeInfoBlock(PayboxHtmlWriter $w)
    {
        $name = $this->getModule()->name;

        $w->html('<link rel="stylesheet" type="text/css" href="'.$this->getCssPath().'admin.css"/>');
        if (version_compare(_PS_VERSION_, '1.6', '<')) {
            $w->html('<link rel="stylesheet" type="text/css" href="'.$this->getCssPath().'admin-compat.css"/>');
        }

        $lang = $this->context->language;
        $template = 'views/templates/admin/config.';
        if (!empty($lang) && !empty($lang->iso_code)
            && is_file(dirname(dirname(__FILE__)).'/'.$template.$lang->iso_code.'.tpl')) {
            $template .= $lang->iso_code.'.tpl';
        } else {
            $template .= 'tpl';
        }

        $w->html($this->getModule()->display(dirname(dirname(__FILE__)).'/epayment.php', $template));
    }

    private function _writeMethodsBlock(PayboxHtmlWriter $w)
    {
        global $cookie,$currentIndex;

        $label = $this->l('Contracts');
        $w->blockStart('paybox_methods_block', $label, $this->getImagePath().'money.png');

        // Add button
        $tpl = '<div class="pbx_method_add"><a href="#"><img src="%sadmin/add.gif" alt="%s" title="%s"/></a></div>';
        $label = $this->l('Add new payment method');
        $w->html(sprintf($tpl, _PS_IMG_, $label, $label));

        // Warning
        $text = $this->l('Warning : Check that the chosen means of payment have been previously configured by PaymentPlatform');
        $w->alertWarn($text);


        // Add method panel
        $this->_writeAddMethodPanel($w);

        // Methods
        $methods = $this->getHelper()->getAllPaymentMethods();
        foreach ($methods as $method) {
            $id = $method['id_card'];
            $type = $method['type_card'];
            $label = Configuration::get('PAYBOX_CARD_LABEL_'.$id);
            if (empty($label)) {
                $label = $method['label'];
            }
            $enabled = Configuration::get('PAYBOX_CARD_ENABLED_'.$id);
            if ($enabled === false) {
                $enabled = $method['active'];
            }
            $logo = $this->getModule()->getMethodImageUrl($type);

            $w->html(sprintf('<div class="pbx_method" data-id="%d">', $id));

            // Logo
            $tpl = '<div class="pbx_img"><img src="%s" class="img-responsive"/></div>';
            $w->html(sprintf($tpl, $logo));

            // Label
            $tpl = '<div class="pbx_label"><label for="method[%s][label]">%s</label>';
            $w->html(sprintf($tpl, $id, $this->l('Label')));
            $w->text('method['.$id.'][label]', $label);
            $w->html('</div>');

            $w->html('<div class="pbx_active"><label>');
            $w->checkbox('method['.$id.'][check]', $enabled);
            $w->html(sprintf(' %s</label>', $this->l('Active')));
            $w->html('</div>');

            $w->html('<div class="pbx_details">');
            $w->html(sprintf('%s<ul>', $this->l('This method allows')));
            $tpl = '<li>%s</li>';
            $options = array(
                'debit_expedition' => $this->l('Debit on delivery'),
                'debit_differe' => $this->l('Deferred payment'),
                'remboursement' => $this->l('Refund'),
                'debit_immediat' => $this->l('Paid immediatly'),
                'mixte' => $this->l('Mixed payment method'),
            );
            foreach ($options as $k => $l) {
                if ($method[$k]) {
                    $w->html(sprintf($tpl, $l));
                }
            }
            $w->html('</ul>');
            $w->html('</div>');

            $w->html('<div class="pbx_action">');
            $label = sprintf('<img src="%s"/> %s', _PS_IMG_.'admin/delete.gif', $this->l('Delete'));
            $w->button($label, 'button');
            $w->html('</div>');

            $w->html('</div>');
        }

        $w->html('<div class="pbx_clear">&nbsp;</div>');

        // Save button
        $w->formButton(null, $this->l('Save settings'));


        $w->blockEnd();

        $tpl = <<<EOF
(function($) {
    $(document).ready(function() {
        $('.pbx_method .pbx_action button').click(function() {
            var that = $(this);
            var method = that.parents('.pbx_method');
            var id = method.attr('data-id');
            var label = method.find('.pbx_label input').val();
            if (confirm(%s + ' ' + label)) {
                $('#paybox_delete_card input[name=idCard]').val(id);
                $('#paybox_delete_card').submit();
            }
            return false;
        });
    });
})(jQuery);
EOF;
        $js = sprintf($tpl, json_encode($this->l('Are you sure, do you want delete this card:')));
        $w->js($js);
    }

    private function _writeKwixoBlock(PayboxHtmlWriter $w)
    {
        $kwixo = new PayboxKwixo($this->getModule()->getConfig());

        /*$w->formSelect(
            'PAYBOX_KWIXO',
            $this->l('State after Kwixo payment'),
            $options,
            Configuration::get('PAYBOX_KWYXO')
        );*/

        $id_lang = Configuration::get('PS_LANG_DEFAULT');

        $label = $this->l('Kwixo configuration');
        $w->blockStart('paybox_kwixo_block', $label, $this->getImagePath().'money.png');

        $this->_writeLinks(
            array(
                'paybox_config_block' => $this->l('Configuration'),
                'paybox_settings_block' => $this->l('Parameters'),
                'paybox_methods_block' => $this->l('Contracts'),
            ),
            $w
        );

        //
        // Categories
        //

        // Build select options
        $options = array('0' => $this->l('Choose a type...'));
        foreach ($kwixo->getCategories() as $name => $label) {
            $options[$name] = $this->l($label);
        }

        // Start of UI
        $w->formElementStart('PAYBOX_CAT_TYPE', $this->l('Category Detail'));
        $label = $this->l('Please select a type for each category of your shop');
        $w->formDescription($label);
        $w->html('<table cellspacing="0" cellpadding="0" class="table">');
        $w->html(sprintf(
            '<thead><tr><th>%s</th><th>%s</th></tr></thead><tbody>',
            $this->l('Category'),
            $this->l('Category type')
        ));

        // Default cateogry
        $w->html(sprintf('<tr><td>%s</td><td>', $this->l('Choose default type...')));
        $w->select('category_id', $options, Configuration::get('PAYBOX_DEFAULTCATEGORYID'));
        $w->html('</td>');

        // Categories
        $categories = Category::getSimpleCategories($id_lang);
        foreach ($categories as $category) {
            $w->html(sprintf('<tr><td>%s</td><td>', $w->escape($category['name'])));
            $w->select('cat_'.$category['id_category'], $options, Configuration::get('PAYBOX_CAT_TYPE_'.$category['id_category']));
            $w->html('</td>');
        }

        // End of UI
        $w->html('</tbody></table>');
        $w->formElementEnd();

        //
        // Carriers
        //

        // Build select options
        $carrierTypes = array('0' => $this->l('Choose a carrier type...'));
        foreach ($kwixo->getCarrierType() as $name => $label) {
            $carrierTypes[$name] = $this->l($label);
        }
        $carrierSpeeds = array(
            '1' => $this->l('Standard shipping'),
            '2' => $this->l('Express shipping'),
        );

        // Start of UI
        $w->formElementStart('PAYBOX_CARRIER_TYPE', $this->l('Carrier Detail'));
        $label = $this->l('Please select a carrier type for each carrier use on your shop');
        $w->formDescription($label);
        $w->html('<table cellspacing="0" cellpadding="0" class="table">');
        $w->html(sprintf(
            '<thead><tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr></thead><tbody>',
            $this->l('Carrier'),
            $this->l('Carrier Type'),
            $this->l('Speed'),
            $this->l('Days')
        ));

        // Carriers
        $carriers = Carrier::getCarriers($id_lang, false, false, false, null, false);
        foreach ($carriers as $carrier) {
            $carrierType = Configuration::get('PAYBOX_CARRIER_TYPE_'.$carrier['id_carrier']);
            $carrierSpeed = Configuration::get('PAYBOX_CARRIER_SPEED_'.$carrier['id_carrier']);
            $carrierDays = Configuration::get('PAYBOX_CARRIER_DAYS_'.$carrier['id_carrier']);

            $w->html(sprintf('<tr><td>%s</td><td>', $w->escape($carrier['name'])));
            $w->select('carrier['.$carrier['id_carrier'].'][type]', $carrierTypes, $carrierType);
            $w->html('</td><td>');
            $w->select('carrier['.$carrier['id_carrier'].'][speed]', $carrierSpeeds, $carrierSpeed);
            $w->html('</td><td>');
            $w->text('carrier['.$carrier['id_carrier'].'][days]', $carrierDays);
            $w->html('</td>');
        }

        // End of UI
        $w->html('</tbody></table>');
        $w->formElementEnd();

        $w->formButton(null, $this->l('Save settings'));
        $w->blockEnd();
    }

    private function _writeAddMethodPanel(PayboxHtmlWriter $w)
    {
        $label = $this->l('Add new payment method');
        $w->html('<div id="pbx_method_add_panel" style="display: none;">');
        $w->html('<div class="row"><div class="col-xs-12">');
        $w->html(sprintf('<h4>%s</h4>', $label));

        // Error
        if (!empty($this->_newCardError)) {
            $w->alertError($this->_newCardError);
            $js = <<<EOF
(function($){
    $(document).ready(function(){
        window.setTimeout(function() {
            var panel = $('#pbx_method_add_panel');
            window.scrollTo(0, panel.position().top);
            panel.show();
        }, 10);
    });
})(jQuery);
EOF;
            $w->js($js);
        }

        // Documentation link
        $label = $this->l('This form allows you to add a new payment method. Don\'t use it unless PaymentPlaform Support ask you to. Please refer to the PaymentPlaform manual to find valid settings.');
        $w->alertWarn(html_entity_decode($label));

        $w->html('</div></div>');

        $w->html('<div class="row"><div class="col-md-6">');

        // Label
        $w->formText(
            'label',
            $this->l('Card Label'),
            '',
            $this->l('Display to order page'),
            40
        );

        // Type
        $w->formText(
            'payment_type',
            $this->l('PBX_TYPEPAIEMENT'),
            '',
            $this->l('See PaymentPlatform manual for allowed values'),
            40
        );

        // Type
        $w->formText(
            'card_type',
            $this->l('PBX_TYPECARTE'),
            '',
            $this->l('See PaymentPlatform manual for allowed values'),
            40
        );

        $w->html('</div><div class="col-md-6">');

        // Logo
        $w->formFile(
            'logo_card',
            $this->l('Logo')
        );

        // Capture on shipping
        $w->formCheckbox(
            'debit_expedition',
            $this->l('Paid shipping')
        );

        // Immediate capture
        $w->formCheckbox(
            'debit_immediat',
            $this->l('Paid immediatly')
        );

        // Delayed capture
        $w->formCheckbox(
            'debit_differe',
            $this->l('Deferred payment')
        );

        // Refund
        $w->formCheckbox(
            'remboursement',
            $this->l('Refund')
        );

        // Refund
        $w->formCheckbox(
            'mixte',
            $this->l('Mixed payment method (may have several payment notifications)')
        );

        // 3DS
        $w->formSelect(
            '3ds',
            $this->l('3-D Secure'),
            array(
                '0' => $this->l('Not supported'),
                '1' => $this->l('Optional'),
                '2' => $this->l('Mandatory'),
            )
        );

        $w->html('</div></div>');

        $w->html('<div class="row"><div class="col-xs-12">');
        $w->formButton(null, $this->l('Add card'));
        $w->html('</div></div>');
        $w->html('</div><br/>');

        $js = <<<EOF
(function($) {
    $(document).ready(function() {
        $('.pbx_method_add a').click(function() {
            var panel = $('#pbx_method_add_panel');
            if (panel.css('display') == 'none') {
                panel.show();
            }
            else {
                panel.hide();
            }
            return false;
        });
        $('#pbx_method_add_panel button').click(function() {
            $('#paybox_settings_form input[name=admin_action]').val('newcard');
        });
    });
})(jQuery);
EOF;
        $w->js($js);
    }

    private function _writeSettingsBlock(PayboxHtmlWriter $w)
    {
        $label = $this->l('Parameters');
        $w->blockStart('paybox_settings_block', $label, $this->getImagePath().'lock.png');

        $site = $this->getConfig()->getSite();
        $rank = $this->getConfig()->getRank();
        $identifier = $this->getConfig()->getIdentifier();
        $hmacKey = $this->getConfig()->getHmacKey();

        if (($site == '1999888') || ($rank == '77') || ($identifier == '3262411')
            || ($hmacKey == '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF')) {
            $w->formAlert(
                'payboxDefaultAlert',
                $this->l('The default identifiers below are those of a general test account. Once you have registered with PaymentPlatform, your dedicated identifiers will be sent to you by email.'),
                true,
                '0px'
            );
        }

        $this->_writeLinks(array(
            'paybox_config_block' => $this->l('Configuration'),
            'paybox_methods_block' => $this->l('Contracts'),
        ), $w);

        $w->formText(
            'PAYBOX_SITE',
            $this->l('Site'),
            $site,
            $this->l('Site number (provided by PaymentPlatform).'),
            40
        );
        $w->formText(
            'PAYBOX_RANG',
            $this->l('Rank'),
            $rank,
            $this->l('Rank number (provided by PaymentPlatform, last 2 digits).'),
            40
        );
        $w->formText(
            'PAYBOX_IDENTIFIANT',
            $this->l('Identifier'),
            $identifier,
            $this->l('PaymentPlatform identifier (provided by PaymentPlatform).'),
            40
        );
        $w->formText(
            'PAYBOX_KEYTEST',
            $this->l('HMAC key'),
            $hmacKey,
            $this->l('Secret HMAC key created using the PaymentPlatform Back-Office.'),
            40
        );

        $w->formButton(null, $this->l('Save settings'));
        $w->blockEnd();
    }

    private function _writeServerBlock(PayboxHtmlWriter $w)
    {
        $errors = array();
        if (!extension_loaded('curl')) {
            $errors[] = $this->l('php-curl extension is not loaded');
        }
        if (!extension_loaded('openssl')) {
            $errors[] = $this->l('php-openssl extension is not loaded');
        }

        if (!empty($errors)) {
            $label = $this->l('Server configuration');
            $w->blockStart('paybox_server_block', $label, $this->getImagePath().'server.png');

            $count = count($errors);
            if ($count > 1) {
                $label =  $this->l('There are').$count.' '.$this->l('errors');
            } else {
                $label = $this->l('There is').$count.' '.$this->l('error');
            }
            $content = sprintf('<h3>%s</h3><ol>', $label);
            $errors[] = $this->l('Please contact your server administrator');
            foreach ($errors as $error) {
                $content .= sprintf('<li>%s</li>', $error);
            }
            $content .= '</ol>';

            $w->alertError($content);

            $w->blockEnd();
        }
    }

    private function _getLatestModuleVersion()
    {
        $client = new PayboxCurl();
        $client->setTimeout(10);
        $client->setUserAgent('PrestaShop Verifone e-commerce module');
        $client->setFollowRedirect(false);
        $error = null;

        $testUrl = 'http://www1.paybox.com/modules/ps_latest_version.php';
        try {
            $response = $client->get($testUrl);
            if (!is_array($response)) {
                $this->getModule()->logDebug(sprintf(' Invalid response type %s', gettype($response)));
            } elseif ($response['code'] != 200) {
                $this->getModule()->logDebug(sprintf(' Invalid response code %s', $response['code']));
            } else {
                $responseContent = $response['body'];
                $this->getModule()->logDebug(sprintf(' Verifone e-commerce version check answer: %s', $responseContent));

                $responseContent = Tools::jsonDecode($responseContent);
                return $responseContent;
            }
        } catch (Exception $e) {
            $this->getModule()->logDebug(sprintf(' Exception %s: %s', get_class($e), $e->getMessage()));
            $error = $e;
        }

        return false;
    }

    private function _writeModuleVersionCheck($w)
    {
        $currentVersion = $this->getModule()->version;
        $this->getModule()->logDebug(sprintf('Checking Verifone e-commerce update to version %s', $currentVersion));
        $latestVersionContent = $this->_getLatestModuleVersion();

        if (false !== $latestVersionContent) {
            $latestVersion = $latestVersionContent->version;

            if (Tools::version_compare($currentVersion, $latestVersion, '<')) {
                $changeLog = '';
                if (isset($latestVersionContent->message) && !empty($latestVersionContent->message)) {
                    $changeLog = '<strong>'.$this->l('Informations').'</strong><br />'.$latestVersionContent->message.'<br /><br />';
                }
                $message = sprintf($this->l('UpdateMessage'), $currentVersion, $latestVersion, $changeLog, $latestVersionContent->url);
                $w->alertWarn(Tools::htmlentitiesDecodeUTF8($message));
            }

            if (property_exists($latestVersionContent, 'documentation')) {
                Configuration::updateValue('PAYBOX_DOC_URL', $latestVersionContent->documentation);
            }

            $w->helpWidget($this->l('Help'), $this->l('See the documentation for help'), Configuration::get('PAYBOX_DOC_URL'));
        }
    }

    public function getContent()
    {
        $w = new PayboxHtmlWriter($this->getModule());

        $this->_writeModuleVersionCheck($w);

        $this->_writeServerBlock($w);
        $this->_writeInfoBlock($w);

        $url = $this->getAdminUrl();

        $w->formStart('paybox_settings_form', $url);
        $w->html('<input type="hidden" name="admin_action" value="config"/>');
        $this->_writeSettingsBlock($w);
        $this->_writeConfigurationBlock($w);
        $this->_writeMethodsBlock($w);
        // $this->_writeKwixoBlock($w);
        $w->formEnd();

        $tpl = '<form id="paybox_delete_card" action="%s" method="post" enctype="multipart/form-data">';
        $w->html(sprintf($tpl, $this->getAdminUrl()));
        $w->html('<input type="hidden" name="admin_action" value="deletecard"/>');
        $w->html('<input type="hidden" name="idCard" value=""/>');
        $w->html('</form>');

        return (string)$w;
    }

    public function _processDeleteCard()
    {
        $id = intval(Tools::getValue('idCard'));
        if (!empty($id)) {
            $sql = 'DELETE FROM `'._DB_PREFIX_.'paybox_card` '
                .'WHERE `id_card`='.$id;
            Db::getInstance()->execute($sql);
            return $this->displayConfirmation($this->l('Card\'s information deleted'));
        }
        return '';
    }

    public function _processNewCard()
    {
        $db = Db::getInstance();
        $errors = array();

        $paymentType = Tools::getValue('payment_type');
        $cardType = Tools::getValue('card_type');

        if (empty($paymentType) || empty($cardType)
            || empty($_FILES['logo_card'])
            || !is_uploaded_file($_FILES['logo_card']['tmp_name'])
            || empty($_FILES['logo_card']['size'])) {
            $this->_newCardError = $this->l('All field are required');
            return '';
        }

        $paymentType = strtoupper($paymentType);
        $cardType = strtoupper($cardType);

        // This payment method must not exist
        $sql = 'SELECT id_card FROM `'._DB_PREFIX_.'paybox_card` '
            .'WHERE type_payment = \''.$db->escape($paymentType)
            .'\' AND type_card = \''.$db->escape($cardType).'\'';
        if ($db->getValue($sql)) {
             $this->_newCardError = $this->l('This card already Exists');
             return '';
        }

        // Save image
        $srcFile = $_FILES['logo_card']['tmp_name'];
        $dstFile = dirname(dirname(__FILE__)).'/img/';
        $ext = strtolower(pathinfo($_FILES['logo_card']['name'], PATHINFO_EXTENSION));
        $dstFile .= $cardType.'.'.$ext;
        $res = copy($srcFile, $dstFile);
        if (!$res) {
            $this->_newCardError = $this->l('File copy failed');
            return '';
        }

        // Features
        $label = Tools::getValue('label');
        $shipping = Tools::getValue('debit_expedition') ? 1 : 0;
        $immediate = Tools::getValue('debit_immediat') ? 1 : 0;
        $differed = Tools::getValue('debit_differe') ? 1 : 0;
        $refund = Tools::getValue('remboursement') ? 1 : 0;
        $mixte = Tools::getValue('mixte') ? 1 : 0;
        $threeds = Tools::getValue('3ds');

        if ((!$shipping) && (!$immediate) && (!$differed) && (!$refund)) {
            $this->_newCardError = $this->l('Thank you to select a type of flow');
            return '';
        }

        // Add card
        $sql = 'INSERT INTO `%spaybox_card` (`type_payment`,'
            .'`type_card`,`label`,`active`,`debit_expedition`,`debit_immediat`,'
            .'`debit_differe`,`remboursement`,`mixte`,`3ds`) VALUES ("%s", "%s", "%s", %d, %d, '
            .'%d, %d, %d, %d, %d);';
        $sql = sprintf(
            $sql,
            _DB_PREFIX_,
            $db->escape($paymentType),
            $db->escape($cardType),
            $db->escape($label),
            0,
            $shipping,
            $immediate,
            $differed,
            $refund,
            $mixte,
            (int)$threeds
        );

        $res = $db->execute($sql);
        if (!$res) {
            $this->_newCardError = $this->l('Error when creating this card.');
            return '';
        }

        // Save shop specific information for 1.5+
        $id = $db->Insert_ID();
        $name = 'PAYBOX_CARD_ENABLED_'.$id;
        Configuration::updateValue($name, 0);
        $name = 'PAYBOX_CARD_LABEL_'.$id;
        Configuration::updateValue($name, $label);

        return $this->displayConfirmation($this->l('Card\'s information added'));
    }

    public function _processSaveConfig()
    {
        $crypt = new PayboxEncrypt();
        $encryptedKeys = array(
            'PAYBOX_KEYTEST',
            'PAYBOX_PASS',
        );

        // Saving parameters
        $vars = $this->getModule()->getConfig()->getDefaults();
        foreach ($vars as $name => $default) {
            $value = Tools::getValue($name);
            if (in_array($name, $encryptedKeys)) {
                $value = $crypt->encrypt($value);
            }
            Configuration::updateValue($name, $value);
        }

        // Saving payment methods
        $methods = Tools::getValue('method');
        if (!empty($methods)) {
            foreach ($methods as $key => $value) {
                $name = 'PAYBOX_CARD_ENABLED_'.$key;
                Configuration::updateValue($name, isset($value['check']) ? 1 : 0);
                $name = 'PAYBOX_CARD_LABEL_'.$key;
                Configuration::updateValue($name, $value['label']);

                $sql = 'UPDATE `'._DB_PREFIX_.'paybox_card` SET `active` = '.(isset($value['check']) ? 1 : 0).'
                    WHERE `id_card` = '.(int)$key;
                Db::getInstance()->execute($sql);
            }
        }
/*
        // Kwixo
        Configuration::updateValue('PAYBOX_DEFAULTCATEGORYID', intval($_POST['category_id']));
        Configuration::updateValue('PAYBOX_NBDELIVERYDAYS', intval(Tools::getValue('PAYBOX_NBDELIVERYDAYS')));
        Configuration::updateValue('PAYBOX_RNP', intval(Tools::getValue('PAYBOX_RNP')));
        $carriers = Carrier::getCarriers(Configuration::get('PS_LANG_DEFAULT'), false, false, false, NULL, false);
        foreach ($carriers as $carrier) {
            if (isset($_POST['carrier'][$carrier['id_carrier']])) {
                $values = $_POST['carrier'][$carrier['id_carrier']];
                Configuration::updateValue('PAYBOX_CARRIER_TYPE_'.$carrier['id_carrier'], stripslashes($values['type']));
                Configuration::updateValue('PAYBOX_CARRIER_SPEED_'.$carrier['id_carrier'], stripslashes($values['speed']));
                Configuration::updateValue('PAYBOX_CARRIER_DAYS_'.$carrier['id_carrier'], stripslashes($values['days']));
            }
        }
*/
        $categories = Category::getSimpleCategories(Configuration::get('PS_LANG_DEFAULT'));
        foreach ($categories as $categorie) {
            if (isset($_POST['cat_'.$categorie['id_category']])) {
                Configuration::updateValue('PAYBOX_CAT_TYPE_'.$categorie['id_category'], Tools::getValue('cat_'.$categorie['id_category']));
            }
        }

        return $this->displayConfirmation($this->l('PaymentPlatform information updated'));
    }

    public function processAction()
    {
        switch (Tools::getValue('admin_action')) {
            case 'config':
                return $this->_processSaveConfig();
                break;
            case 'newcard':
                return $this->_processNewCard();
                break;
            case 'deletecard':
                return $this->_processDeleteCard();
                break;
            default:
        }
    }
}
