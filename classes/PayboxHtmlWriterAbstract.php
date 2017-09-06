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

/**
 * Base class of HTML writers
 */
abstract class PayboxHtmlWriterAbstract
{
    private $_html = '';
    private $_js = '';

    public function __toString()
    {
        // Adding JavaScript
        $tpl = '%s<script type="text/javascript">'
            .'(function($){$(document).ready(function(){%s});})(jQuery);'
            .'</script>';
        return sprintf($tpl, $this->_html, $this->_js);
    }

    public function escape($text)
    {
        return Tools::htmlentitiesUTF8($text);
    }

    public function html($html)
    {
        $this->_html .= $html;
    }

    public function js($js)
    {
        $this->_js .= $js;
    }

    public function forceReload()
    {
        $this->html('<script>window.location = window.location.href;</script>');
    }

    abstract protected function _alert($type, $content, $id, $show);
    abstract public function alertConf($content, $id = null, $show = true);
    abstract public function alertError($content, $id = null, $show = true);
    abstract public function alertWarn($content, $id = null, $show = true);
    abstract public function blockEnd();
    abstract public function blockStart($id, $label, $image = null);
    abstract public function button($label, $type = 'submit');
    abstract public function formAlert($id, $content, $show = true, $marginTop = '-50px');
    abstract public function formButton($name, $label);
    abstract public function formCheckbox($name, $label, $checked = false, $value = '1', $description = null, $show = true);
    abstract public function formDescription($description);
    abstract public function formElementEnd();
    abstract public function formElementStart($name, $label, $show = true);
    abstract public function formEnd();
    abstract public function formFile($name, $label, $description = null, $show = true);
    abstract public function formLabel($name, $label);
    abstract public function formSelect($name, $label, array $options, $current = null, $default = null, $description = null, $show = true, $sortOptions = true);
    abstract public function formStart($id, $action);
    abstract public function formText($name, $label, $current = '', $description = null, $size = null, $more = null, $show = true);
    abstract public function select($name, array $options, $current = null);
    abstract public function helpWidget($title, $subtitle, $link);
    abstract public function badge($text, $mode);
}
