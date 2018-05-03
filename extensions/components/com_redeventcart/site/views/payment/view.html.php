<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Review View class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartViewPayment extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */
	public function display($tpl = null)
	{
		// Callback from integration
		JPluginHelper::importPlugin('redeventcart_payment');
		RFactory::getDispatcher()->trigger('onRedeventcartReceivePaymentCallback');
	}
}
