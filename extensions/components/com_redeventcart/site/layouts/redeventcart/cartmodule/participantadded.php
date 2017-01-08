<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

extract($displayData);

echo JText::sprintf('COM_REDEVENTCART_CART_ADDED_TITLE_S_ON_DATE_S_IN_LOCATION_S_COUNTRY_S_DURATION_D',
	$session->getEvent()->title,
	$session->getFormattedStartDate(),
	$session->getVenue()->name,
	$session->getVenue()->country,
	$session->getDurationDays()
);
