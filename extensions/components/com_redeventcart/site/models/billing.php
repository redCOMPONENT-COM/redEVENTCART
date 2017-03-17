<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Billing Model class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartModelBilling extends RModel
{
	public function getCart()
	{
		$app = JFactory::getApplication();
		$current = $app->getUserState('redeventcart.cart', 0);

		$cart = RedeventcartEntityCart::load($current);

		if (!$cart->checkParticipantsAreSubmitted())
		{
			throw new LogicException(JText::_('COM_REDEVENTCART_ERROR_INVALID_STATE_PARTICIPANTS_NOT_SUBMITTED'));
		}

		return $cart;
	}
}
