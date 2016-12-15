<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart ajax controller
 *
 * @since  1.0.0
 */
class RedeventcartControllerCart extends JControllerLegacy
{
	/**
	 * Add session to cart
	 *
	 * @return void
	 */
	public function addsession()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$currentCart->addParticipant($this->input->getInt('id'), $this->input->getInt('spg_id'));
			$app->setUserState('redeventcart.cart', $currentCart->get('id'));

			echo new JResponseJson($currentCart->toArray());
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * Add participant in cart view
	 *
	 * @return void
	 */
	public function addparticipant()
	{
		try
		{
			$app = JFactory::getApplication();
			$sessionId = $this->input->getInt('session_id');
			$sessionPricegroupId = $this->input->getInt('spg_id');
			$i = $this->input->getInt('index');

			if (!$cartId = $app->getUserState('redeventcart.cart', 0))
			{
				throw new RuntimeException('Cannot add participant to empty cart');
			}

			$currentCart = RedeventcartEntityCart::load($cartId);

			$id = $currentCart->addParticipant($sessionId, $sessionPricegroupId);

			// Get participant panel
			$participant = RedeventcartEntityParticipant::load($id);
			$isCollapsed = false;
			$html = RedeventcartHelperLayout::render('redeventcart.cart.participant', compact('participant', 'i', 'isCollapsed'));

			echo new JResponseJson($html);
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * summary of cart content for module
	 *
	 * @return void
	 */
	public function cartsummary()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$data = array(
				'totalVatExcl' => RHelperCurrency::getFormattedPrice($currentCart->getTotalPrice(), $currentCart->getCurrency()),
				'totalVatIncl' => RHelperCurrency::getFormattedPrice(
					$currentCart->getTotalPrice() + $currentCart->getTotalVat(), $currentCart->getCurrency()
				),
				'sessions' => array()
			);

			$data = array();

			foreach ($currentCart->getParticipants() as $participant)
			{
				$session = $participant->getSession();
				$itemData = array(
					'id' => $participant->id,
					'session_id' => $participant->session_id,
					'label' => RedeventcartHelperLayout::render('redeventcart.cart.sessionlabel', compact('session'))
				);

				$data[] = $itemData;
			}

			echo new JResponseJson($data);
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * Empty current cart
	 *
	 * @return void
	 */
	public function emptyCart()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$currentCart->deleteAll();

			echo new JResponseJson("ok");
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * Add participant in cart view
	 *
	 * @return void
	 */
	public function priceitems()
	{
		try
		{
			$app = JFactory::getApplication();

			$cartId = $app->getUserState('redeventcart.cart', 0);
			$currentCart = RedeventcartEntityCart::load($cartId);

			$data = array(
				'totalVatExcl' => RHelperCurrency::getFormattedPrice($currentCart->getTotalPrice(), $currentCart->getCurrency()),
				'totalVatIncl' => RHelperCurrency::getFormattedPrice(
					$currentCart->getTotalPrice() + $currentCart->getTotalVat(), $currentCart->getCurrency()
				),
				'sessions' => array()
			);

			foreach ($currentCart->getSessionsitems() as $sessionId => $sessionItems)
			{
				$sessionData = array(
					'sessionId' => $sessionId,
					'items' => array()
				);

				foreach ($sessionItems->getItems() as $item)
				{
					$itemData = array(
						'count' => $item->getCount(),
						'currency' => $item->getCurrency(),
						'sku' => $item->getSku(),
						'label' => $item->getLabel(),
						'priceVatExcl' => RHelperCurrency::getFormattedPrice($item->getPriceVatExcluded(), $item->getCurrency()),
						'priceVatIncl' => RHelperCurrency::getFormattedPrice($item->getPriceVatIncluded(), $item->getCurrency()),
						'totalVatExcl' => RHelperCurrency::getFormattedPrice($item->getPriceVatExcluded() * $item->getCount(), $item->getCurrency()),
						'totalVatIncl' => RHelperCurrency::getFormattedPrice($item->getPriceVatIncluded() * $item->getCount(), $item->getCurrency()),
						'vat' => $item->getVat()
					);

					$sessionData['items'][] = $itemData;
				}

				$data['sessions'][] = $sessionData;
			}

			echo new JResponseJson($data);
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * Get a session label
	 *
	 * @return void
	 */
	public function sessionLabel()
	{
		try
		{
			$sessionId = $this->input->getInt('id');
			$session = RedeventEntitySession::load($sessionId);

			echo new JResponseJson(RedeventcartHelperLayout::render('redeventcart.cartmodule.participantadded', compact('session')));
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}
}
