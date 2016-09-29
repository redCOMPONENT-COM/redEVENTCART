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
	 * Get items route link
	 *
	 * @return  link
	 */
	public static function getConversationsRoute()
	{
		$needles = array(
			'items'  => array()
		);

		// Create the link
		$link = 'index.php?option=com_redeventcart&view=items';

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
	 * Get item route link
	 *
	 * @param   int  $id  item id
	 *
	 * @return  link
	 */
	public static function getItemRoute($id)
	{
		// Create the link
		$link = 'index.php?option=com_redeventcart&view=item&id=' . $id;

		if ($item = self::findItem())
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
						self::$lookup[$view] = array();
					}

					if ($view == 'item')
					{
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
					elseif ($view == 'items')
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
					foreach ($ids as $id)
					{
						if (isset(self::$lookup[$view][(int) $id]))
						{
							return self::$lookup[$view][(int) $id];
						}
					}

					if ($view == 'items' && isset(self::$lookup[$view]))
					{
						return self::$lookup[$view];
					}
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
