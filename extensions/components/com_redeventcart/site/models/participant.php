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
class RedeventcartModelParticipant extends RModelAdmin
{
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission for the component.
	 */
	protected function canDelete($record)
	{
		$app = JFactory::getApplication();
		$userCart = $app->getUserState('redeventcart.cart', 0);

		return $record->cart_id == $userCart;
	}
}
