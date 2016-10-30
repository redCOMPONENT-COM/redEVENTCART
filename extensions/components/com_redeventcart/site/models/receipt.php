<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Receipt Model class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartModelReceipt extends RModel
{
	/**
	 * Get cart
	 *
	 * @return RedeventcartEntityCart
	 */
	public function getCart()
	{
		$entity = RedeventcartEntityCart::load($this->getState('cartId'));

		return $entity;
	}

	/**
	 * Populate state
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$this->setState('cartId', $app->input->get('cartId'));

		parent::populateState();
	}
}
