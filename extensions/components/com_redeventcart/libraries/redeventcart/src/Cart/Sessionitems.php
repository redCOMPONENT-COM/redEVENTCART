<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\Cart;

use Symfony\Component\Console\Exception\RuntimeException;

defined('JPATH_BASE') or die;

/**
 * Session items prices
 *
 * @package  Redeventcart.Libraries
 * @since    1.0
 */
class Sessionitems
{
	/**
	 * @var  \RedeventcartEntityParticipant[]
	 */
	private $participants;

	/**
	 * @var Item[]
	 */
	private $items;

	/**
	 * Sessionitems constructor.
	 *
	 * @param   \RedeventcartEntityParticipant[]  $participants  participants
	 */
	public function __construct($participants)
	{
		$this->participants = $participants;
	}

	/**
	 * Get items
	 *
	 * @return Item[]
	 *
	 * @since 1.0
	 */
	public function getItems()
	{
		if (empty($this->items))
		{
			foreach ($this->participants as $participant)
			{
				$this->add($participant);
			}
		}

		return $this->items;
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
		$currency = false;

		foreach ($this->getItems() as $item)
		{
			if (!$itemCurrency = $item->getCurrency())
			{
				continue;
			}

			if (!$currency)
			{
				$currency = $itemCurrency;
				continue;
			}

			if ($currency != $itemCurrency)
			{
				throw new RuntimeException('Different currencies are used for same session participants');
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
		$total = 0;

		foreach ($this->getItems() as $item)
		{
			$total += $item->getPrice() * $item->getCount();
		}

		return $total;
	}

	/**
	 * Get VAT total
	 *
	 * @return float
	 *
	 * @since 1.0
	 */
	public function getTotalVat()
	{
		$total = 0;

		foreach ($this->getItems() as $item)
		{
			if ($vat = $item->getVat())
			{
				$total += $item->getPrice() * $vat;
			}
		}

		return $total;
	}

	/**
	 * Add a participant
	 *
	 * @param   \RedeventcartEntityParticipant  $participant  participant
	 *
	 * @return void
	 */
	private function add(\RedeventcartEntityParticipant $participant)
	{
		if ($participant->submitter_id)
		{
			$this->addFromSubmitter($participant);
		}
		else
		{
			$this->addFromSession($participant);
		}
	}

	/**
	 * Add from session
	 *
	 * @param   \RedeventcartEntityParticipant  $participant  participant
	 *
	 * @return void
	 */
	private function addFromSession(\RedeventcartEntityParticipant $participant)
	{
		if ($participant->session_pricegroup_id)
		{
			$sessionPriceGroup = \RedeventEntitySessionpricegroup::load($participant->session_pricegroup_id);

			$this->addFromSessionPricegroup($sessionPriceGroup);
		}
		else
		{
			$session = $participant->getSession();

			if (!$pricegroups = $session->getUserActivePricegroups())
			{
				$this->addFromFreeSession($session);
			}
			else
			{
				$this->addFromSessionPricegroup(reset($pricegroups));
			}
		}
	}

	/**
	 * Add from session without price
	 *
	 * @param   \RedeventEntitySession  $session  session
	 *
	 * @return void
	 */
	private function addFromFreeSession(\RedeventEntitySession $session)
	{
		$sku = 'SESSIONPRICE_FREE_' . $session->id;

		$label = \RedeventcartHelperLayout::render('redeventcart.cart.sessionlabel', compact('session'));

		if (!isset($this->items[$sku]))
		{
			$this->items[$sku] = new Item(
				array(
					'sku' => $sku,
					'label' => $label,
					'price' => 0,
					'vat' => 0,
					'currency' => $session->getEvent()->getEventtemplate()->getForm()->currency
				)
			);
		}

		$this->items[$sku]->add();
	}

	/**
	 * Add from session price group
	 *
	 * @param   \RedeventEntitySessionpricegroup  $sessionPriceGroup  session price group
	 *
	 * @return void
	 */
	private function addFromSessionPricegroup(\RedeventEntitySessionpricegroup $sessionPriceGroup)
	{
		$session = $sessionPriceGroup->getSession();

		$sku = $sessionPriceGroup->sku ?: 'SESSIONPRICE_' . $sessionPriceGroup->id;

		$label = \RedeventcartHelperLayout::render('redeventcart.cart.sessionlabel', compact('session'));

		if (!isset($this->items[$sku]))
		{
			$this->items[$sku] = new Item(
				array(
					'sku' => $sku,
					'label' => $label,
					'price' => $sessionPriceGroup->price,
					'vat' => $sessionPriceGroup->vat,
					'currency' => $sessionPriceGroup->currency
				)
			);
		}

		$this->items[$sku]->add();
	}

	/**
	 * Add from participant submission info
	 *
	 * @param   \RedeventcartEntityParticipant  $participant  participant
	 *
	 * @return void
	 */
	private function addFromSubmitter(\RedeventcartEntityParticipant $participant)
	{
		$submitter = $participant->getSubmitter();

		if (!$paymentRequests = $submitter->getPaymentRequests())
		{
			$this->addFromFreeSession($participant->getSession());
		}

		foreach ($paymentRequests as $paymentRequest)
		{
			foreach ($paymentRequest->getItems() as $paymentrequestitem)
			{
				$this->addFromPaymentrequestitem($paymentrequestitem);
			}
		}
	}

	/**
	 * Add from session price group
	 *
	 * @param   \RdfEntityPaymentrequestitem  $paymentrequestitem  payment request item
	 *
	 * @return void
	 */
	private function addFromPaymentrequestitem(\RdfEntityPaymentrequestitem $paymentrequestitem)
	{
		$sku = $paymentrequestitem->sku ?: 'PAYMENTREQUESTITEM_' . $paymentrequestitem->id;

		if (!isset($this->items[$sku]))
		{
			$this->items[$sku] = new Item(
				array(
					'sku' => $sku,
					'label' => $paymentrequestitem->label,
					'price' => $paymentrequestitem->price,
					'vat' => $paymentrequestitem->vat,
					'currency' => $paymentrequestitem->getPaymentrequest()->currency
				)
			);
		}

		$this->items[$sku]->add();
	}
}
