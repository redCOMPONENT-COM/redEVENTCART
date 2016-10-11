<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

extract($displayData);
?>
<form method="post" enctype="application/x-www-form-urlencoded" class="participant-form">
	<?= $fieldsHtml ?>
	<button type="button" class="btn btn-default participant-submit"><?= JText::_('COM_REDEVENTCART_CART_SUBMIT_PARTICIPANT') ?></button>

	<input type="hidden" name="id" value="<?= $id ?>"/>
</form>
