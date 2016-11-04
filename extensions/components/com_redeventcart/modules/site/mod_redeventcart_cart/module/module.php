<?php
/**
 * @package     Redeventcart.Module
 * @subpackage  Frontend.mod_redeventcart_cart
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

defined('_JEXEC') or die;

use \Joomla\Registry\Registry;

JLoader::import('reditem.library');

/**
 * Module to display category information.
 *
 * @since  1.0.0
 */
class ModredeventcartcartModule
{
	/**
	 * @var Registry
	 */
	private $params;

	/**
	 * ModredeventcartcartModule constructor.
	 *
	 * @param   Registry  $params  module params
	 */
	public function __construct($params)
	{
		$this->params = $params;
	}
}
