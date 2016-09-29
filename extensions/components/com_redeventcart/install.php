<?php
/**
 * @package    Redeventcart.Installer
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

// Find redCORE installer to use it as base system
if (!class_exists('Com_RedcoreInstallerScript'))
{
	$searchPaths = array(
		// Install
		dirname(__FILE__) . '/redCORE',
		// Discover install
		JPATH_ADMINISTRATOR . '/components/com_redcore'
	);

	if ($redcoreInstaller = JPath::find($searchPaths, 'install.php'))
	{
		require_once $redcoreInstaller;
	}
}

// Register component prefix
JLoader::registerPrefix('Redeventcart', __DIR__);

// Load redITEM Library
JLoader::import('redeventcart.library');

/**
 * Script file of Redeventcart component
 *
 * @package  Redeventcart.Installer
 *
 * @since    1.0
 */
class Com_RedeventcartInstallerScript extends Com_RedcoreInstallerScript
{
}
