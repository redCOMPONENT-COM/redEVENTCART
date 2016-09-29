<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart View class
 *
 * @package  Redeventcart.Site
 * @since    1.0
 */
class RedeventcartViewCart extends JViewLegacy
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

		$this->title   = $menu->params->get('custom_title', JText::_('COM_REDEVENTCART_VIEW_TITLE_CART'));
		$this->intro   = $menu->params->get('intro');
		$this->state = $this->get('state');
		$this->items = $this->get('items');
		$this->user = JFactory::getUser();

		parent::display($tpl);
	}
}
