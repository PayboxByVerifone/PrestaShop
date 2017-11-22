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
*  @version   2.2.3
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * HTML write for PrestaShop 1.4/1.5
 */
class PayboxDb
{
    public $db;
    
    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function execute($sql, $use_cache = true)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            return $this->db->execute(sprintf($sql, _DB_PREFIX_, _MYSQL_ENGINE_), $use_cache);
        } else {
            return $this->db->execute(sprintf($sql, _DB_PREFIX_, _MYSQL_ENGINE_), $use_cache);
        }
    }

    public function insert($table, $data, $null_values = false, $use_cache = true)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $table = _DB_PREFIX_.$table;
            return (bool)$this->db->autoExecute($table, $data, 'INSERT');
        } else {
            return $this->db->insert($table, $data, $null_values, $use_cache);
        }
    }

    public function get($sql, $use_cache = true)
    {
        return $this->db->getValue($sql, $use_cache);
    }

    public function getMsgError()
    {
        return $this->db->getMsgError();
    }
}
