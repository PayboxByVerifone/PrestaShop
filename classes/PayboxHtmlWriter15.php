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

require_once dirname(__FILE__).'/PayboxHtmlWriterAbstract.php';

/**
 * HTML write for PrestaShop 1.4/1.5
 */
class PayboxHtmlWriter extends PayboxHtmlWriterAbstract
{
    public function _alert($type, $content, $id, $show)
    {
        $attrs = '';
        if (!empty($id)) {
            $attrs .= sprintf(' id="%s"', $id);
        }
        if (!$show) {
            $attrs .= ' style="display: none"';
        }
        $tpl = '<div class="alert alert-epayment %s"%s>%s</div>';
        $content = $content;
        $this->html(sprintf($tpl, $type, $attrs, $content));
    }

    public function alertConf($content, $id = null, $show = true)
    {
        $this->_alert('conf', $content, $id, $show);
    }

    public function alertError($content, $id = null, $show = true)
    {
        $this->_alert('error', $content, $id, $show);
    }

    public function alertWarn($content, $id = null, $show = true)
    {
        $this->_alert('warn', $content, $id, $show);
    }

    public function blockEnd()
    {
        $this->html('</div></fieldset>');
    }

    public function blockStart($id, $label, $image = null)
    {
        $tpl = '<br/><fieldset id="%s"><legend>%s</legend><div class="pbx_block_content">';
        if (!empty($image)) {
            $label = sprintf('<img src="%s" alt="%s"/>%s', $this->escape($image), $label, $label);
        }
        $this->html(sprintf($tpl, $id, $label));
    }

    public function button($label, $type = 'submit')
    {
        $tpl = '<button class="button" type="%s">%s</button>';
        $this->html(sprintf($tpl, $type, $label));
    }

    public function checkbox($name, $checked = false, $value = '1')
    {
        $attrs = '';
        if ($checked) {
            $attrs .= ' checked="checked"';
        }
        $this->html(sprintf('<input type="checkbox" id="%s" name="%s" value="%s"%s/>', $this->escape($name), $this->escape($name), $this->escape($value), $attrs));
    }

    public function formAlert($id, $content, $show = true, $marginTop = '-50px')
    {
        $styles = array(
            'width: 300px',
            'position: absolute',
            'margin-left: 560px',
            'margin-top: '.$marginTop,
            'font-weight: normal',
        );
        if (!$show) {
            $styles[] = 'display: none';
        }
        $tpl = '<div class="alert error" style="%s" id="%s">%s</div>';
        $this->html(sprintf($tpl, implode('; ', $styles), $this->escape($id), $content));
    }

    public function formButton($name, $label)
    {
        if (empty($name)) {
            $tpl = '<p class="center"><button class="button" type="submit">%s</button></p>';
            $this->html(sprintf($tpl, $label));
        } else {
            $tpl = '<p class="center"><input class="button" type="submit" name="%s" value="%s" /></p>';
            $this->html(sprintf($tpl, $this->escape($name), $label));
        }
    }

    public function formCheckbox($name, $label, $checked = false, $value = '1', $description = null, $show = true)
    {
        $this->formElementStart($name, $label, $show);
        $attrs = '';
        if ($checked) {
            $attrs .= ' checked="checked"';
        }
        $this->html(sprintf('<input type="checkbox" id="%s" name="%s" value="%s"%s/>', $this->escape($name), $this->escape($name), $this->escape($value), $attrs));
        $this->formDescription($description);
        $this->formElementEnd();
    }

    public function formDescription($description)
    {
        if (!empty($description)) {
            $tpl = '<p>%s</p>';
            $this->html(sprintf($tpl, $description));
        }
    }

    public function formElementEnd()
    {
        $this->html('</div></div>');
    }

    public function formElementStart($name, $label, $show = true)
    {
        $styles = $show ? '' : ' style="display:none;"';
        $this->html(sprintf('<div id="%s_container"%s>', $this->escape($name), $styles));
        $this->formLabel($name, $label);
        $this->html('<div class="margin-form">');
    }

    public function formEnd()
    {
        $this->html('</form>');
    }

    public function formFile($name, $label, $description = null, $show = true)
    {
        $this->formElementStart($name, $label, $show);
        $this->html(sprintf('<input type="file" id="%s" name="%s"/>',
            $this->escape($name), $this->escape($name)));
        $this->formDescription($description);
        $this->formElementEnd();
    }

    public function formLabel($name, $label)
    {
        $tpl = '<label for="%s">%s</label>';
        $this->html(sprintf($tpl, $this->escape($name), $label));
    }

    public function formSelect($name, $label, array $options, $current = null, $default = null, $description = null, $show = true, $sortOptions = true)
    {
        // Sort options if needed
        if ($sortOptions) {
            asort($options);
        }

        // Check current value
        if (is_null($current) || ($current === false) || !array_key_exists($current, $options)) {
            $current = $default;
        }

        $this->formElementStart($name, $label, $show);
        $this->select($name, $options, $current);
        $this->formDescription($description);
        $this->formElementEnd();
    }

    public function formStart($id, $action)
    {
        $tpl = '<form id="%s" class="defaultForm" action="%s" method="post" enctype="multipart/form-data">';
        $this->html(sprintf($tpl, $this->escape($id), $this->escape($action)));
    }

    public function formText($name, $label, $current = '', $description = null, $size = null, $more = null, $show = true)
    {
        $this->formElementStart($name, $label, $show);
        $attrs = '';
        if (!empty($size)) {
            $attrs = sprintf(' size="%d"', intval($size));
        }
        $this->html(sprintf('<input type="text" id="%s" name="%s" value="%s"%s/>', $this->escape($name), $this->escape($name), $this->escape($current), $attrs));
        if ($more) {
            $this->html(sprintf('<b>&nbsp;&nbsp;%s</b>', $more));
        }
        $this->formDescription($description);
        $this->formElementEnd();
    }

    public function text($name, $current = '', $size = null)
    {
        $attrs = '';
        if (!empty($size)) {
            $attrs = sprintf(' size="%d"', intval($size));
        }
        $this->html(sprintf('<input type="text" id="%s" name="%s" value="%s"%s/>', $this->escape($name), $this->escape($name), $this->escape($current), $attrs));
    }

    public function rawRowStart()
    {
        $this->html('<div>');
    }

    public function rawRowEnd()
    {
        $this->html('</div>');
    }

    public function select($name, array $options, $current = null)
    {
        $this->html(sprintf('<select name="%s" id="%s">', $this->escape($name), $this->escape($name)));

        // For each option
        $optionTpl = '<option value="%s"%s>%s</option>';
        foreach ($options as $value => $label) {
            $attrs = $current == $value ? ' selected="selected"' : '';
            $this->html(sprintf($optionTpl, $this->escape($value), $attrs, $label));
        }

        $this->html('</select>');
    }

    public function helpWidget($title, $subtitle, $link)
    {
        $this->html(sprintf('<div class="toolbarBox" style="background:none;border:none;"><a class="toolbar_btn" style="float:right;border:none;" href="%s" target="_blank" title="%s" ><span class="process-icon-help"></span></a></div>', $this->escape($link), $this->escape($title)));
    }

    public function badge($text, $mode)
    {
        if ($mode) {
            $cssStyle = 'background-color: LimeGreen;';
        } else {
            $cssStyle = 'background-color: Crimson;';
        }

        return sprintf('<span style="color: #FFFFFF;padding:2px 5px;%s">%s</span>', $cssStyle, $text);
    }
}
