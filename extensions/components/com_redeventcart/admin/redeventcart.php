<?php
/**
 * @package    Redeventcart.Backend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$app   = JFactory::getApplication();
$user  = JFactory::getUser();
$input = $app->input;

// Access check.
if (!$user->authorise('core.manage', 'com_redeventcart'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Load redeventcart Library
JLoader::import('redeventcart.library');

// Register component prefix
JLoader::registerPrefix('Redeventcart', __DIR__);

$controller = $input->getCmd('view', 'items');

// Set the controller page
if (!file_exists(JPATH_COMPONENT . '/controllers/' . $controller . '.php'))
{
	$controller = 'redeventcart';
	$input->set('view', 'items');
}

RHelperAsset::load('redeventcart.js', 'com_redeventcart');
RHelperAsset::load('redeventcart.backend.css', 'com_redeventcart');

$controller = JControllerLegacy::getInstance('Redeventcart');
$controller->execute($input->getCmd('task', ''));
$controller->redirect();
