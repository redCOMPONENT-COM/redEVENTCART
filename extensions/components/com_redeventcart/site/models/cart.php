<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart Model class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartModelCart extends RModel
{
	/**
	 * Get cart
	 *
	 * @return RedeventcartEntityCart
	 */
	public function getCart()
	{
		$app = JFactory::getApplication();
		$current = $app->getUserState('redeventcart.cart', 0);

		return RedeventcartEntityCart::load($current);
	}
}
