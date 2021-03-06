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
		$app = JFactory::getApplication();

		// Prevent caching, as we pull data from user session
		$app->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate', true);
		$app->setHeader('Pragma', 'no-cache', true);
		$app->setHeader('Expires', '0', true);

		try
		{
			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			if (!$currentCart->getTotalPrice())
			{
				// There is nothing to pay, so bypass payment
				$currentCart->createAttendeesFromParticipants();

				$this->setRedirect(RedeventcartHelperRoute::getReceiptRoute($currentCart->id));

				// Clear from user session, so he can have a new cart
				$app->setUserState('redeventcart.cart', null);

				return;
			}

			// Deleguate payment handling to plugins
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
