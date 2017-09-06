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
*  @version   2.0.0
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Kwixo specific code
 */
class PayboxKwixo
{
    private $_config;

    // category defined by Receive&Pay
    private $_categories = array(
        1 => 'Alimentation & gastronomie',
        2 => 'Auto & moto',
        3 => 'Culture & divertissements',
        4 => 'Maison & jardin',
        5 => 'Electroménager',
        6 => 'Enchères et achats groupés',
        7 => 'Fleurs & cadeaux',
        8 => 'Informatique & logiciels',
        9 => 'Santé & beauté',
        10 => 'Services aux particuliers',
        11 => 'Services aux professionnels',
        12 => 'Sport',
        13 => 'Vêtements & accessoires',
        14 => 'Voyage & tourisme',
        15 => 'Hifi, photo & vidéos',
        16 => 'Téléphonie & communication',
        17 => 'Bijoux et métaux précieux',
        18 => 'Articles et accessoires pour bébé',
        19 => 'Sonorisation & lumière'
    );

    private $_carrierType = array(
        //1 => 'Retrait de la marchandise chez le marchand',
        //2 => 'Utilisation d\'un réseau de points-retrait tiers (type kiala, alveol, etc.)',
        //3 => 'Retrait dans un aéroport, une gare ou une agence de voyage',
        4 => 'Transporteur (La Poste, Colissimo, UPS, DHL... ou tout transporteur privé)',
        5 => 'Emission d’un billet électronique, téléchargements'
    );

    public function __construct(PayboxConfig $config)
    {
        $this->_config = $config;
    }

    public function buildKwixoParams(Cart $cart, array $additionalParams = array())
    {
        global $cookie;

        // Customer
        $customer = new Customer($cart->id_customer);

        // Countries
        $billTo = new Address($cart->id_address_invoice);
        $billToCountry = new Country($billTo->id_country);
        $shipTo = new Address($cart->id_address_delivery);
        $shipToCountry = new Country($shipTo->id_country);

        // Carrier
        $carrier = new Carrier($cart->id_carrier);

        // Language
        $langId = intval($cart->id_lang);

        // Date and delay
        $orderDate = date("Y-m-d H:i:s");
        $deliveryDelay = intval(Configuration::get('PAYBOX_CARRIER_DAYS_'.$carrier->id));
        if (empty($deliveryDelay)) {
            $deliveryDelay = 3;
        }
        $deliveryDate = mktime(0, 0, 0, date('m'), date('d') + $deliveryDelay);
        $deliveryDate = date('Y-m-d', $deliveryDate);

        // Delivery Speed
        $deliverySpeed = Configuration::get('PAYBOX_CARRIER_TYPE_'.$carrier->id);
        if (!in_array($deliverySpeed, array(1, 2))) {
            $deliverySpeed = 1;
        }

        // Delivery type
        $deliveryType = Configuration::get('PAYBOX_CARRIER_TYPE_'.$carrier->id);
        if (!in_array($deliveryType, array_keys($this->getCarrierType()))) {
            $deliveryType = 4;
        }

        $values = array();

        // Billing information
        $values['PBX_BILLTO_CIVILITY']      = $this->getGender($customer);
        $values['PBX_BILLTO_NAME_FIRST']    = $this->cleanupUpString($billTo->firstname);
        $values['PBX_BILLTO_NAME_LAST']     = $this->cleanupUpString($billTo->lastname);
        $values['PBX_BILLTO_OFFICE']        = $this->cleanupUpString($billTo->company);
        $values['PBX_BILLTO_MOBILE']        = $this->cleanUpPhone($billTo->phone_mobile);
        $values['PBX_BILLTO_PHONE_HOME']    = $this->cleanUpPhone($billTo->phone);
        $values['PBX_BILLTO_EMAIL']         = $customer->email;
        $values['PBX_BILLTO_STREET_LINE_1'] = $this->cleanupUpString($billTo->address1);
        $values['PBX_BILLTO_STREET_LINE_2'] = $this->cleanupUpString($billTo->address2);
        $values['PBX_BILLTO_POSTALCODE']    = $billTo->postcode;
        $values['PBX_BILLTO_CITY']          = $this->cleanupUpString($billTo->city);
        $values['PBX_BILLTO_COUNTRY']       = $this->cleanupUpString($billToCountry->name[$langId]);

        // Shipping information
        if ($deliveryType == 4) {
            $values['PBX_SHIPTO_CIVILITY']      = $this->getGender($customer);
            $values['PBX_SHIPTO_NAME_FIRST']    = $this->cleanupUpString($shipTo->firstname);
            $values['PBX_SHIPTO_NAME_LAST']     = $this->cleanupUpString($shipTo->lastname);
            $values['PBX_SHIPTO_OFFICE']        = $this->cleanupUpString($shipTo->company);
            $values['PBX_SHIPTO_MOBILE']        = $this->cleanUpPhone($shipTo->phone_mobile);
            $values['PBX_SHIPTO_PHONE_HOME']    = $this->cleanUpPhone($shipTo->phone);
            $values['PBX_SHIPTO_EMAIL']         = $customer->email;
            $values['PBX_SHIPTO_STREET_LINE_1'] = $this->cleanupUpString($shipTo->address1);
            $values['PBX_SHIPTO_STREET_LINE_2'] = $this->cleanupUpString($shipTo->address2);
            $values['PBX_SHIPTO_POSTALCODE']    = $shipTo->postcode;
            $values['PBX_SHIPTO_CITY']          = $this->cleanupUpString($shipTo->city);
            $values['PBX_SHIPTO_COUNTRY']       = $this->cleanupUpString($shipToCountry->name[$langId]);
        }

        // Carrier information
        $values['PBX_SHIPTO_SHIPPER_NAME']   = $this->cleanupUpString($carrier->name);
        $values['PBX_SHIPTO_SHIPPER_ID']     = $carrier->id;
        $values['PBX_SHIPTO_SHIPPER_SIGN']   = $this->cleanupUpString($carrier->name);
        $values['PBX_SHIPTO_DELIVERY_TYPE']  = $deliveryType;
        $values['PBX_SHIPTO_DELIVERY_SPEED'] = $deliverySpeed;
        $values['PBX_DELIVERY_DATE']         = $deliveryDate;

        // Order information
        $values['PBX_ORDER_DATE']            = $orderDate;

        // Products information
        $items = array();
        $products = $cart->getProducts();
        $default = Configuration::get('PAYBOX_DEFAULTCATEGORYID');
        if (empty($default)) {
            $default = 1;
        }
        foreach ($products as $product) {
            if (_PS_VERSION_ >= 1.4) {
                $categories = Product::getProductCategories($product['id_product']);
            } else {
                $categories = Product::getIndexedCategories($product['id_product']);
            }

            $selected = false;
            foreach ($categories as $category) {
                $value = Configuration::get('PAYBOX_CAT_TYPE_'.$category['id_category']);
                if ($value) {
                    $selected = Configuration::get('PAYBOX_CAT_TYPE_'.$category['id_category']);
                    break;
                }
            }

            if (round($product['price'] * 100) > 0) {
                $items[] = '{"reference":"'.$this->cleanupUpString($product['reference']).'",'
                    .'"type":"'.($selected !== false ? $selected : $default).'",'
                    .'"label":"'.$this->cleanupUpString($product['name']).'",'
                    .'"quantity":"'.$product['cart_quantity'].'",'
                    .'"unitprice":"'.round($product['price']*100).'"}';
            }
        }
        $values['PBX_PRODUCT_DETAILS']        = '['.implode(',', $items).']';

        // Adding additionnal informations
        $values = array_merge($values, $additionalParams);

        return $values;
    }

    public function cleanUpPhone($text)
    {
        $text = preg_replace('#^[^0-9]+$#', '', $text);
        if (preg_match('#^33[1-9][0-9]{8}$#', $text, $matches)) {
            return '+'.$text;
        } else if (preg_match('#^0[1-9][0-9]{8}$#', $text, $matches)) {
            return $text;
        }
        throw new Exception('Invalid phone number "'.$text.'"');
    }

    public function cleanupUpString($str)
    {
        // TODO: Code to review
        if (function_exists('mb_strtolower')) {
            $str = mb_strtolower($str, 'utf-8');
        }

        $str = trim($str);
        if (!function_exists('mb_strtolower') || !Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')) {
            $str = Tools::replaceAccentedChars($str);
        }

        // Remove all non-whitelist chars.
        if (Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')) {
            $str = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]-\pL]/u', '', $str);
        } else {
            $str = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]-]/', '', $str);
        }
        
        $str = preg_replace('/[\s\'\:\/\[\]-]+/', ' ', $str);
        //$str = str_replace(array(' ', '/'), '-', $str);

        // If it was not possible to lowercase the string with mb_strtolower, we do it after the transformations.
        // This way we lose fewer special chars.
        if (!function_exists('mb_strtolower')) {
            $str = strtolower($str);
        }

        return $str;
    }

    public function getCategories()
    {
        return $this->_categories;
    }

    public function getCarrierType()
    {
        return $this->_carrierType;
    }

    public function getGender(Customer $customer)
    {
        return ($customer->id_gender == 1) ? 'monsieur' : 'madame';
    }
}
