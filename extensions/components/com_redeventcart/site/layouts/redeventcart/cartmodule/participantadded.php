<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

extract($displayData);

echo JText::sprintf('COM_REDEVENTCART_CART_PARTICPANT_ADDED_DATE_AND_LOCATION_S_S_S_D',
	$session->getFormattedStartDate(),
	$session->getVenue()->name,
	$session->getVenue()->country,
	$session->getDurationDays()
);
