<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart controller
 *
 * @since  1.0.0
 */
class RedeventcartControllerCart extends JControllerLegacy
{
	/**
	 * Start payment
	 *
	 * @return void
	 */
	public function payment()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			JPluginHelper::importPlugin('redeventcart_payment');
			$this->dispatcher = RFactory::getDispatcher();
			RFactory::getDispatcher()->trigger('onRedeventcartStartPayment', array(&$currentCart));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
}
