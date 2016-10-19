<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Cart
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Billing entity.
 *
 * @since  1.0.0
 */
class RedeventcartEntityBilling extends RedeventcartEntityBase
{
	/**
	 * Get billing cart
	 *
	 * @return RedeventcartEntityCart
	 */
	public function getCart()
	{
		$item = $this->loadItem();

		if (!$item->cart_id)
		{
			return false;
		}

		return RedeventcartEntityCart::load($item->cart_id);
	}
}
