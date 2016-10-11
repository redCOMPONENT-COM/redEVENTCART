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
 * Participant entity.
 *
 * @since  1.0.0
 */
class RedeventcartEntityParticipant extends RedeventcartEntityBase
{
	/**
	 * Get participant session
	 *
	 * @return RedeventEntitySession
	 */
	public function getSession()
	{
		$item = $this->loadItem();

		if (!$item->session_id)
		{
			return false;
		}

		return RedeventEntitySession::load($item->session_id);
	}
}
