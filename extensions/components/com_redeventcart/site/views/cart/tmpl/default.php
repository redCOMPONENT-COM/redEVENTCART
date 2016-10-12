<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
$collapsed = false;

RHtmlMedia::loadFrameworkJs();
RHelperAsset::load('cartview.js');
RHelperAsset::load('cartview.css');

JText::script('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_CONFIRM');
?>
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

<div class="redeventcart">
	<h3><?= $this->title ?></h3>

	<div class="intro">
		<?= $this->intro ?>
	</div>

	<?php foreach ($this->cart->getSessionsParticipants() as $sessionId => $participants): ?>
		<?php $session = RedeventEntitySession::load($sessionId); ?>
		<div class="session">
			<div class="session-title"><?= $session->getEvent()->title ?></div>
			<table class="table">
				<thead>
					<tr>
						<th><?= JText::_('COM_REDEVENTCART_CART_DATE_AND_LOCATION') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_PARTICIPANTS') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_PRICE') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_TOTAL') ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= JText::sprintf('COM_REDEVENTCART_CART_DATE_AND_LOCATION_S_S_S_D',
								$session->getFormattedStartDate(),
								$session->getVenue()->name,
								$session->getVenue()->country,
								$session->getDurationDays()) ?></td>
						<td><input name="participants[]" class="participants-count" value="<?= count($participants) ?>" size="3"/></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<div class="panel-group" role="tablist" aria-multiselectable="true">
				<?php $i = 1; ?>
				<?php foreach ($participants as $participant): ?>
					<?php $id = $session->id . '_' . $i; ?>
					<?php $submitted = $participant->submitter_id > 0; ?>
					<?php $isCollapsed = $collapsed || $submitted; ?>
					<div class="panel panel-default">
						<div class="panel-heading <?= $submitted ? 'submitted' : ''; ?>" role="tab" id="heading_<?= $id ?>">
							<div class="row">
								<div class="col-md-11">
									<h4 class="panel-title">
										<?php $class = $isCollapsed ? 'class="collapsed"' : ''; ?>
										<span class="indicator icon-<?= $isCollapsed ? 'chevron-right' : 'chevron-down' ?> "></span>
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $id ?>" aria-expanded="true" aria-controls="collapse<?= $id ?>" <?= $class ?>>
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
					<?php $i++; ?>
					<?php $collapsed |= !$isCollapsed; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
