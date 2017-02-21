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
	 * Return instance
	 *
	 * @param   int  $submitterId  submitter id
	 *
	 * @return RedeventcartEntityParticipant
	 */
	public function loadBySubmitterId($submitterId)
	{
		$table = $this->getTable();
		$table->load(array('submitter_id' => $submitterId));

		if ($table->id)
		{
			$this->loadFromTable($table);
		}

		return $this;
	}

	/**
	 * Get participant cart
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

	/**
	 * Get participant submitter
	 *
	 * @return RdfEntitySubmitter
	 */
	public function getSubmitter()
	{
		$item = $this->loadItem();

		if (!$item->submitter_id)
		{
			return false;
		}

		return RdfEntitySubmitter::load($item->submitter_id);
	}

	/**
	 * Get participant user
	 *
	 * @return RdfEntitySubmitter
	 */
	public function getUser()
	{
		$item = $this->loadItem();

		if (!$item->user_id)
		{
			return false;
		}

		return JFactory::getUser($item->user_id);
	}
}
