<?php
/**
 * @package     Redeventcart.Module
 * @subpackage  Frontend.mod_redeventcart_cart
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::import('redeventcart.library');
JLoader::registerPrefix('Modredeventcartcart', __DIR__);

$module = new ModredeventcartcartModule($params);

$layout = $params->get('layout', 'default');

$cart = RedeventcartEntityCart::getCurrentInstance();

$showtitle = false;

require JModuleHelper::getLayoutPath('mod_redeventcart_cart', $layout);
