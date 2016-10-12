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

	public function addparticipant()
	{
		try
		{
			$app = JFactory::getApplication();
			$sessionId = $this->input->getInt('session_id');
			$sessionPricegroupId = $this->input->getInt('spg_id');
			$i = $this->input->getInt('index');

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$id = $currentCart->addParticipant($sessionId, $sessionPricegroupId);
			$app->setUserState('redeventcart.cart', $currentCart->get('id'));

			// Get participant panel
			$participant = RedeventcartEntityParticipant::load($id);
			$isCollapsed = false;
			$html = RedeventcartHelperLayout::render('redeventcart.cart.participant', compact('participant', 'i', 'isCollapsed'));

			echo new JResponseJson($html);
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}
}
