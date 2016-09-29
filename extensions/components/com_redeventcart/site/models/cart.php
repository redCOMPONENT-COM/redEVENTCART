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
	public function getItems()
	{
		$app = JFactory::getApplication();
		$current = $app->getUserState('redeventcart.cart', array());
//		echo '<pre>HRE'; echo print_r($current, true); echo '</pre>'; exit;

		return $current;
	}
}
