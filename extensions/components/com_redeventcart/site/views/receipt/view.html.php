<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Billing View class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartViewReceipt extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */
	public function display($tpl = null)
	{
		$app           = JFactory::getApplication();
		$menu          = $app->getMenu()->getActive();
		$params        = $app->getParams();
		$this->params  = $params;

		$this->title   = $menu->params->get('custom_title', JText::_('COM_REDEVENTCART_VIEW_TITLE_RECEIPT'));
		$this->intro   = $menu->params->get('intro');
		$this->cart = $this->get('Cart');
		$this->user = JFactory::getUser();

		JPluginHelper::importPlugin('redeventcart_payment');
		$this->dispatcher = RFactory::getDispatcher();

		$billing = '';

		if ($this->cart->getTotalPrice())
		{
			// Get receipt from the plugin that handled the payment
			$this->dispatcher->trigger('onRedeventcartViewReceipt', array($this->cart, &$billing));
		}

		$this->billing = $billing;

		$this->addGaTracking();

		parent::display($tpl);
	}

	/**
	 * Add google analytics tracking
	 *
	 * @return void
	 */
	public function addGaTracking()
	{
		if (!RdfHelperAnalytics::isEnabled())
		{
			return;
		}

		$params = JFactory::getApplication()->getParams('com_redeventcart');
		$cartParams = new JRegistry($this->cart->params);

		$redFormCart = RdfEntityCart::getInstance();
		$redFormCart->loadByReference($cartParams->get('redform_cart_reference'));

		$transaction = new stdClass;
		$transaction->id =  $redFormCart->invoice_id;
		$transaction->affiliation =  $params->get('ga_affiliation', JFactory::getApplication()->getCfg('sitename'));
		$transaction->revenue =  $this->cart->getTotalPrice();
		$transaction->currency =  $this->cart->getCurrency();

		RdfHelperAnalytics::addTrans($transaction);

		foreach ($redFormCart->getPaymentRequests() as $paymentRequest)
		{
			foreach ($paymentRequest->getItems() as $item)
			{
				$transactionItem = new stdClass;

				$transactionItem->id = $transaction->id;
				$transactionItem->productname = $item->label;
				$transactionItem->sku = $item->sku;
				$transactionItem->category = 'booking';
				$transactionItem->price = $item->price + $item->vat;
				$transactionItem->currency = $transaction->currency;

				RdfHelperAnalytics::addItem($transactionItem);
			}
		}

		RdfHelperAnalytics::trackTrans();
	}
}
