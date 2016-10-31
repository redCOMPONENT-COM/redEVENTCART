<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

extract($displayData);

//echo '<pre>'; echo print_r($answers, true); echo '</pre>';

$filterTypes = array('info', 'submissionprice');
?>
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="heading_<?= $id ?>">
		<h4 class="panel-title">
			<?= JText::_('COM_REDEVENTCART_CART_RECEIPT_PARTICIPANT'); ?>
		</h4>
	</div>

	<div class="panel-body">
		<?php foreach ($answers->getFields() as $field): ?>
			<?php if (!in_array($field->fieldtype, $filterTypes)): ?>
				<div class="form-group">
					<label><?= $field->getLabel() ?></label>
					<?= $field->getValueAsString() ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
