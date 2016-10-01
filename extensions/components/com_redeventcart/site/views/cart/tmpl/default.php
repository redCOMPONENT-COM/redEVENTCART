<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
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
		</div>
	<?php endforeach; ?>
</div>
