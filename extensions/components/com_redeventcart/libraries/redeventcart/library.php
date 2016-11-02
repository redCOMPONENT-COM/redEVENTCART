<?php
/**
 * Redeventcart Library file.
 * Including this file into your application will make Redeventcart available to use.
 *
 * @package    Redeventcart.Library
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('JPATH_PLATFORM') or die;

// JPATH redeventcart defines
define('JPATH_REDEVENTCART_LIBRARY', __DIR__);
define('JPATH_REDEVENTCART_MEDIA', JPATH_ROOT . '/media/com_redeventcart/');

// Load redCORE
$redcoreLoader = JPATH_LIBRARIES . '/redcore/bootstrap.php';

if (!file_exists($redcoreLoader))
{
	throw new Exception(JText::_('COM_REDEVENTCART_FAILED_BOOTSTRAP_REDCORE'), 404);
}

require_once $redcoreLoader;

// Bootstraps redCORE
$redcoreLoader = JPATH_LIBRARIES . '/redcore/bootstrap.php';

if (!file_exists($redcoreLoader) || !JPluginHelper::isEnabled('system', 'redcore'))
{
	throw new Exception(JText::_('COM_REDEVENTCART_REDCORE_INIT_FAILED'), 404);
}

include_once $redcoreLoader;

RBootstrap::bootstrap();

$composerAutoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($composerAutoload))
{
	$loader = require_once $composerAutoload;
}

// Register library prefix
RLoader::registerPrefix('Redeventcart', JPATH_REDEVENTCART_LIBRARY);

// Make available the redeventcart fields
JFormHelper::addFieldPath(JPATH_REDEVENTCART_LIBRARY . '/form/field');

// Make available the redeventcart form rules
JFormHelper::addRulePath(JPATH_REDEVENTCART_LIBRARY . '/form/rules');

RModel::addIncludePath(JPATH_SITE . '/components/com_redeventcart/models');
RTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_redeventcart/tables');

// HTML helpers
JHtml::addIncludePath(__DIR__ . '/html');
RHtml::addIncludePath(__DIR__ . '/html');

// Load library language
$lang = JFactory::getLanguage();
$lang->load('lib_redeventcart', __DIR__);
