<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

extract($displayData);

$id = $participant->id;
?>
<?php $helper = new \Redeventcart\Registration\Receipt($participant); ?>
<?= $helper->getHtml() ?>
