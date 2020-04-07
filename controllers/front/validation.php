<?php
/*
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
*  @category  Module / payments_gateways
*  @version   3.0.13
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
 */
class EpaymentValidationModuleFrontController extends ModuleFrontController
{
	/**
     * @see FrontController::postProcess()
     */
    public function initContent(){
			if(_PS_VERSION_ >= '1.7'){
				$this->setTemplate('module:epayment/views/templates/front/validation.tpl');
			}else{
				$this->setTemplate('validation.tpl');
			}
	}

    public function postProcess()
    {
		$action = isset($_GET['a']) ? $_GET['a'] : null;
		$c = new PayboxController();
		try {
			switch ($action) {
				//Cancel
				case 'c':
					$c->cancelAction();
					break;

				//Failure
				case 'f':
					$c->failureAction();
					break;

				//Redirect
				case 'r':
					$c->redirectAction();
					break;

			   //Success
				case 's':
					$c->successAction();
					break;

				case 'i':
					//file_put_contents('debug.log', file_get_contents('php://input'));die();
					$c->ipnAction();
					break;
				case 'j':
					$c->ipnAction();
					break;

				default:
					$c->defaultAction();
				}
		} catch (Exception $e) {
			header('Status: 500 Error', true, 500);
			echo $e->getMessage();
		}
	}
}
?>
