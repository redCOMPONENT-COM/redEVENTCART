<?php
/**
 * @package    Redeventcart.Plugin
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

extract($displayData);

$user = RedmemberApi::getUser(JFactory::getUser()->get('id'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_ajax&group=redeventcart_billing&plugin=saveBilling&format=html'); ?>"
      method="post">
	<div class="userinfo"><?= $user->username ?></div>
	<button type="submit" class="billing-continue btn btn-primary"><?= JText::_('PLG_REDEVENTCART_BILLING_REDMEMBER_CONTINUE') ?></button>
	<input type="hidden" name="integration" value="redmember"/>
	<input type="hidden" name="Itemid" value="<?= JFactory::getApplication()->input->get('Itemid') ?>"/>
	<?php echo JHTML::_('form.token'); ?>
</form>

