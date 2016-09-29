<?php
/**
 * @package    Redeventcart.Backend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('rbootstrap.tooltip');
JHtml::_('rjquery.chosen', 'select');

$action = JRoute::_('index.php?option=com_redeventcart&view=item&id=' . $this->item->id);
?>
<form action="<?= $action ?>" method="post" name="adminForm" class="form-validate" id="adminForm">
	<div class="row-fluid">
		<div class="col-md-12 col-lg-8">
			<?= $this->form->renderField('name') ?>
			<?= $this->form->renderField('published') ?>
			<?= $this->form->renderField('language') ?>
			<?= $this->form->renderField('id') ?>
		</div>
	</div>

	<input type="hidden" name="task" value=""/>
	<?= JHtml::_('form.token') ?>
</form>
