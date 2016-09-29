<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart ajax controller
 *
 * @since  1.0.0
 */
class RedeventcartControllerCart extends JControllerLegacy
{
	/**
	 * Add session to cart
	 *
	 * @return void
	 */
	public function addsession()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$currentCart->addParticipant($this->input->getInt('id'), $this->input->getInt('spg_id'));
			$app->setUserState('redeventcart.cart', $currentCart->get('id'));

			echo new JResponseJson($currentCart->toArray());
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}
}
