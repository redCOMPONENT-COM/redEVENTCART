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
?>
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
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_<?= $id ?>">
							<h4 class="panel-title">
								<?php $class = $collapsed ? 'class="collapsed"' : ''; ?>
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $id ?>" aria-expanded="true" aria-controls="collapse<?= $id ?>" <?= $class ?>>
									<?= JText::sprintf('COM_REDEVENTCART_CART_PARTICIPANT_D', $i); ?>
								</a>
							</h4>
						</div>
						<?php $in = $collapsed ? '' : 'in'; ?>
						<div id="collapse<?= $id ?>" class="panel-collapse collapse <?= $in ?>" role="tabpanel" aria-labelledby="heading_<?= $id ?>">
							<div class="panel-body">
								<?php $helper = new \Redeventcart\Registration\Edit($participant); ?>
								<?= $helper->getForm() ?>
							</div>
						</div>
					</div>
					<?php $i++; ?>
					<?php $collapsed = true; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
