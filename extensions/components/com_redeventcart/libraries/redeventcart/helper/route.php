<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_BASE') or die;

/**
 * Route helper
 *
 * @since  1.0
 */
abstract class RedeventcartHelperRoute
{
	protected static $lookup;

	/**
	 * Get cart route link
	 *
	 * @return  link
	 */
	public static function getCartRoute()
	{
		$needles = array(
			'cart'  => array()
		);

		// Create the link
		$link = 'index.php?option=com_redeventcart&view=cart';

		if ($item = self::findItem($needles))
		{
			$link .= '&Itemid=' . $item;
		}
		elseif ($item = self::findItem())
		{
			$link .= '&Itemid=' . $item;
		}
		else
		{
			$link .= '&Itemid=' . JFactory::getApplication()->input->getInt('Itemid', 0);
		}

		return $link;
	}

	/**
	 * Get billing route link
	 *
	 * @return  link
	 */
	public static function getBillingRoute()
	{
		$needles = array(
			'billing'  => array()
		);

		// Create the link
		$link = 'index.php?option=com_redeventcart&view=billing';

		if ($item = self::findItem($needles))
		{
			$link .= '&Itemid=' . $item;
		}
		elseif ($item = self::findItem())
		{
			$link .= '&Itemid=' . $item;
		}
		else
		{
			$link .= '&Itemid=' . JFactory::getApplication()->input->getInt('Itemid', 0);
		}

		return $link;
	}

	/**
	 * Find items
	 *
	 * @param   array  $needles  array of require
	 *
	 * @return  string
	 */
	protected static function findItem($needles = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu('site');

		// Prepare the reverse lookup array.
		if (self::$lookup === null)
		{
			self::$lookup = array();

			$component = JComponentHelper::getComponent('com_redeventcart');

			$items     = $menus->getItems('component_id', $component->id);

			foreach ($items as $item)
			{
				if (isset($item->query) && isset($item->query['view']))
				{
					$view = $item->query['view'];

					if (!isset(self::$lookup[$view]))
					{
						self::$lookup[$view] = $item->id;
					}
				}
			}
		}

		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(self::$lookup[$view]))
				{
					return self::$lookup[$view];
				}
			}
		}
		else
		{
			$active = $menus->getActive();

			if ($active)
			{
				return $active->id;
			}
		}

		return null;
	}

	/**
	 * Search a menu Item id.
	 *
	 * @param   array  $needles  Query parts to search for.
	 *
	 * @return  mixed  Integer if found | null otherwise
	 */
	public static function searchItemId($needles = array())
	{
		return self::findItem($needles);
	}
}
