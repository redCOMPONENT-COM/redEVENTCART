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
 * Cart entity.
 *
 * @since  1.0.0
 */
class RedeventcartEntityCart extends RedeventcartEntityBase
{
	/**
	 * @var RedeventcartEntityParticipant[]
	 */
	private $participants;

	/**
	 * Add a participant for a session
	 *
	 * @param   int  $sessionId            session id
	 * @param   int  $sessionPriceGroupId  session price group id
	 *
	 * @return Cart
	 */
	public function addParticipant($sessionId, $sessionPriceGroupId = null)
	{
		$session = RedeventEntitySession::load($sessionId);

		if (!$session->isValid())
		{
			throw new InvalidArgumentException('Missing or invalid session id');
		}

		JPluginHelper::getPlugin('redeventcart');
		$error = array();
		RFactory::getDispatcher()->trigger('onRedeventcartCheckAddSession', array($this, $session, &$error));

		if (!empty($error))
		{
			throw new InvalidArgumentException(implode("\n", $error));
		}

		if (!$this->hasId())
		{
			$data = array(
				"created" => \JFactory::getDate()->toSql()
			);

			if ($user_id = JFactory::getUser()->get('id'))
			{
				$data['user_id'] = $user_id;
			}

			$this->id = $this->save($data);
		}

		$participant = new RedeventcartEntityParticipant;

		$data = array(
			"cart_id" => $this->id,
			"session_id" => $sessionId
		);

		if ($sessionPriceGroupId)
		{
			$data["session_pricegroup_id"] = $sessionPriceGroupId;
		}

		$participant->save($data);

		// Refresh
		$this->getParticipants();

		return $this;
	}

	/**
	 * Get participants
	 *
	 * @return RedeventcartEntityParticipant[]
	 */
	public function getParticipants()
	{
		if (is_null($this->participants) && $this->hasId())
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('*')
				->from('#__redeventcart_cart_participant')
				->where('cart_id = ' . $this->id);

			$db->setQuery($query);
			$res = $db->loadObjectList();

			$this->participants = $res ? RedeventcartEntityParticipant::loadArray($res) : $res;
		}

		return $this->participants;
	}

	/**
	 * Export to array for ajax response
	 *
	 * @return array
	 */
	public function toArray()
	{
		$sessionsParticipants = $this->getSessionsParticipants();

		return array_map(
			function($sessionId, $sessionParticipants) {
				return array('session_id' => $sessionId, "count" => count($sessionParticipants));
			},
			array_keys($sessionsParticipants),
			$sessionsParticipants
		);
	}

	/**
	 * Get participants indexed by sessions
	 *
	 * @return Participant[]
	 */
	private function getSessionsParticipants()
	{
		$sessions = array();

		foreach ($this->getParticipants() as $participant)
		{
			if (!isset($sessions[$participant->session_id]))
			{
				$sessions[$participant->session_id] = array();
			}

			$sessions[$participant->session_id][] = $participant;
		}

		return $sessions;
	}
}
