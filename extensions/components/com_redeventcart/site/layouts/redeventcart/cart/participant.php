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
$submitted = $participant->submitter_id > 0;
?>
<div class="panel panel-default">
	<div class="panel-heading <?= $submitted ? 'submitted' : ''; ?>" role="tab" id="heading_<?= $id ?>">
		<div class="row">
			<div class="col-md-11">
				<h4 class="panel-title">
					<span class="indicator icon-<?= $isCollapsed ? 'chevron-right' : 'chevron-down' ?> "></span>
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $id ?>">
						<?= JText::sprintf('COM_REDEVENTCART_CART_PARTICIPANT_D', $i); ?>
					</a>

					<span class="participant-state <?= $submitted ? '' : 'hidden'; ?> icon-ok"></span>
				</h4>
			</div>
			<div class="col-md-1">
				<span class="participant-delete icon-trash"></span>
			</div>
		</div>
	</div>
	<?php $in = $isCollapsed ? '' : 'in'; ?>
	<div id="collapse<?= $id ?>" class="panel-collapse collapse <?= $in ?>" role="tabpanel" aria-labelledby="heading_<?= $id ?>">
		<div class="panel-body">
			<?php $helper = new \Redeventcart\Registration\Edit($participant); ?>
			<?= $helper->getForm() ?>
		</div>
	</div>
</div>
