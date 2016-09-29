<?php
/**
 * @package    Redeventcart.Frontend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();

// Load redeventcart Library
JLoader::import('redeventcart.library');

// Load redevent Library
JLoader::import('redevent.bootstrap');
RedeventBootstrap::bootstrap();

// Register component prefix
JLoader::registerPrefix('Redeventcart', __DIR__);

try
{
	$controller = JControllerLegacy::getInstance('redeventcart');
	$controller->execute($app->input->get('task'));
	$controller->redirect();
}
catch (Exception $e)
{
	if (JDEBUG)
	{
		echo 'Exception:' . $e->getMessage();
		echo "<pre>" . $e->getTraceAsString() . "</pre>";
		exit(0);
	}

	throw $e;
}
