<?php
/**
 * @package    Redeventcart.plugins
 * @copyright  Copyright (C) 2012 - 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

JLoader::import('redeventcart.library');

/**
 * Redeventcart System plugin
 *
 * @package  Redform.plugins
 * @since    2.5
 */
class PlgSystemRedeventcart extends JPlugin
{
	public function onBeforeRender()
	{
		if (JFactory::getApplication()->isAdmin())
		{
			return;
		}


		if (JFactory::getDocument()->getType() != 'html')
		{
			return;
		}

		RHtmlMedia::loadFrameworkJs();
		RHelperAsset::load('redeventcart.js', 'com_redeventcart');
	}
}
