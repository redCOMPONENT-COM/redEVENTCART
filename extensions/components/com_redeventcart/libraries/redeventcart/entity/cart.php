<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Cart
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redeventcart\Cart\Sessionitems;

/**
 * Cart entity.
 *
 * @since  1.0.0
 */
class RedeventcartEntityCart extends RedeventcartEntityBase
{
	/**
	 * @var RedeventcartEntityParticipant[]
	 *
	 * @since 1.0
	 */
	private $participants;

	/**
	 * Get current user current cart
	 *
	 * @return $this
	 *
	 * @since version 1.0
	 */
	public static function getCurrentInstance()
	{
		$app = JFactory::getApplication();
		$cartId = $app->getUserState('redeventcart.cart', 0);

		return self::load($cartId);
	}

	/**
	 * Add a participant for a session
	 *
	 * @param   int  $sessionId            session id
	 * @param   int  $sessionPriceGroupId  session price group id
	 *
	 * @return int participant id
	 *
	 * @since 1.0
	 */
	public function addParticipant($sessionId, $sessionPriceGroupId = null)
	{
		$this->checkAddParticipant($sessionId, $sessionPriceGroupId);

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

		$id = $participant->save($data);

		// Refresh
		$this->getParticipants();

		return $id;
	}

	/**
	 * Check that it is allowed to add a participant for a session
	 *
	 * @param   int  $sessionId            session id
	 * @param   int  $sessionPriceGroupId  session price group id
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *
	 * @since 1.0
	 */
	public function checkAddParticipant($sessionId, $sessionPriceGroupId = null)
	{
		$session = RedeventEntitySession::load($sessionId);

		if (!$session->isValid())
		{
			throw new InvalidArgumentException('Missing or invalid session id');
		}

		if (!$this->isEmpty())
		{
			if ($sessionPriceGroupId)
			{
				$sessionProceGroup = RedeventEntitySessionpricegroup::load($sessionPriceGroupId);
				$newCurrency = $sessionProceGroup->currency;
			}
			else
			{
				$newCurrency = $session->getEvent()->getForm()->currency;
			}

			if ($newCurrency !== $this->getCurrency())
			{
				throw new InvalidArgumentException(JText::_('LIB_REDEVENTCART_ERROR_ADDING_MULTIPLE_CURRENCIES'));
			}
		}

		JPluginHelper::importPlugin('redeventcart');
		$error = array();
		RFactory::getDispatcher()->trigger('onRedeventcartCheckAddParticipant', array($this, $session, &$error));

		if (!empty($error))
		{
			throw new InvalidArgumentException(implode("\n", $error));
		}
	}

	/**
	 * Clear current cart billing info
	 *
	 * @param   int  $billingId  billing id
	 *
	 * @return void
	 *
	 * @since 1.0
	 */
	public function setBilling($billingId)
	{
		if (!$this->hasId())
		{
			return false;
		}

		$item = $this->getItem();
		$item->billing_id = $billingId;
		$this->save($item);
	}

	/**
	 * Get currency
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function getCurrency()
	{
		if (!$this->hasId())
		{
			return false;
		}

		$currency = false;

		foreach ($this->getSessionsitems() as $sessionitems)
		{
			if (!$sessionCurrency = $sessionitems->getCurrency())
			{
				continue;
			}

			$currency = $currency ?: $sessionCurrency;

			if ($currency != $sessionCurrency)
			{
				throw new RuntimeException('Multiple currencies used in same cart !');
			}
		}

		return $currency;
	}

	/**
	 * Get total price without vat
	 *
	 * @return float
	 *
	 * @since 1.0
	 */
	public function getTotalPrice()
	{
		if (!$this->hasId())
		{
			return false;
		}

		$total = 0;

		foreach ($this->getSessionsitems() as $sessionitems)
		{
			$total += $sessionitems->getTotalPrice();
		}

		return $total;
	}

	/**
	 * Get total vat
	 *
	 * @return float
	 *
	 * @since 1.0
	 */
	public function getTotalVat()
	{
		if (!$this->hasId())
		{
			return false;
		}

		$total = 0;

		foreach ($this->getSessionsitems() as $sessionitems)
		{
			$total += $sessionitems->getTotalVat();
		}

		return $total;
	}

	/**
	 * Get participants
	 *
	 * @return RedeventcartEntityParticipant[]
	 *
	 * @since 1.0
	 */
	public function getParticipants()
	{
		if (is_null($this->participants) && $this->hasId())
		{
			$item = $this->getItem();

			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('*')
				->from('#__redeventcart_cart_participant')
				->where('cart_id = ' . $item->id);

			$db->setQuery($query);
			$res = $db->loadObjectList();

			$this->participants = $res ? RedeventcartEntityParticipant::loadArray($res) : array();
		}

		return $this->participants;
	}

	/**
	 * Get sessions items
	 *
	 * @return Sessionitems[]
	 *
	 * @since 1.0
	 */
	public function getSessionsitems()
	{
		if (!$this->hasId())
		{
			return array();
		}

		if (!$this->sessionsItems)
		{
			$sessionsItems = array();

			foreach ($this->getSessionsParticipants() as $sessionId => $participants)
			{
				$sessionsItems[$sessionId] = new Sessionitems($participants);
			}

			$this->sessionsItems = $sessionsItems;
		}

		return $this->sessionsItems;
	}

	/**
	 * Get participants indexed by sessions
	 *
	 * @return Participant[]
	 *
	 * @since 1.0
	 */
	public function getSessionsParticipants()
	{
		if (!$this->hasId())
		{
			return array();
		}

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

	/**
	 * Check if cart is empty
	 *
	 * @return boolean
	 */
	public function isEmpty()
	{
		if (!$this->hasId())
		{
			return true;
		}

		return $this->getParticipants() ? false : true;
	}

	/**
	 * Export to array for ajax response
	 *
	 * @return array
	 *
	 * @since 1.0
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
}
