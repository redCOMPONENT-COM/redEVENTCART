<?php
/**
 * @package    Redeventcart.Frontend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Routing class for com_redeventcart
 *
 * @since  1.0
 */
class RedeventcartRouter extends JComponentRouterBase
{
	/**
	 * Build the route for the com_redeventcart component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 */
	public function build(&$query)
	{
		$segments = array();

		if (isset($query['view']))
		{
			$segments[] = $query['view'];
			unset($query['view']);
		}

		return $segments;
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 */
	public function parse(&$segments)
	{
		$vars = array();

		$view = isset($segments[0]) ? $segments[0] : null;

		switch ($view)
		{
			case 'billing':
			case 'cart':
			case 'payment':
			case 'receipt':
			case 'billing':
				$vars['view'] = $view;
				break;
		}

		return $vars;
	}
}

/**
 * Method for create query
 *
 * @param   array  &$query  A named array
 *
 * @return	array
 */
function redeventcartBuildRoute(&$query)
{
	$router = new RedeventcartRouter;

	return $router->build($query);
}

/**
 * Parse short link to full link
 *
 * @param   array  $segments  A named array
 *
 * @return  array  $vars
 */
function redeventcartParseRoute($segments)
{
	$router = new RedeventcartRouter;

	return $router->parse($segments);
}
