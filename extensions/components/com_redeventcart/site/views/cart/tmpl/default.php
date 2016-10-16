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

<div class="redeventcart cart">
	<h3><?= $this->title ?></h3>

	<div class="intro">
		<?= $this->intro ?>
	</div>

	<?php foreach ($this->cart->getSessionsParticipants() as $sessionId => $participants): ?>
		<?php $session = RedeventEntitySession::load($sessionId); ?>
		<div class="session" session_id="<?= $sessionId ?>">
			<div class="session-title"><?= $session->getEvent()->title ?></div>
			<table class="table items-table">
				<thead>
					<tr>
						<th><?= JText::_('COM_REDEVENTCART_CART_DATE_AND_LOCATION') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_PARTICIPANTS') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_PRICE') ?></th>
						<th><?= JText::_('COM_REDEVENTCART_CART_TOTAL') ?></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

			<div class="panel-group" role="tablist" aria-multiselectable="true">
				<?php $i = 1; ?>
				<?php foreach ($participants as $participant):
					$submitted = $participant->submitter_id > 0;
					$isCollapsed = $collapsed || $submitted;

					echo RedeventcartHelperLayout::render('redeventcart.cart.participant', compact('participant', 'i', 'isCollapsed'));

					// Set collapsed to true for next participants if this one was not collapsed
					$collapsed |= !$isCollapsed;
					$i++;
				endforeach; ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<h4 class="panel-title">
									<span class="indicator icon-plus"></span>
									<span class="participant-add" session_id="<?= $sessionId ?>">
										<?= JText::_('COM_REDEVENTCART_CART_ADD_PARTICIPANT'); ?>
									</span>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="cart-footer">
		<div class="total">
			<div class="total-label"><?= JText::_('COM_REDEVENTCART_CART_TOTAL') ?></div>
			<div class="total-price"></div>
		</div>

		<div class="checkout">
			<a href="<?= JRoute::_(RedeventcartHelperRoute::getBillingRoute()) ?>" class="btn btn-default"><?= JText::_('COM_REDEVENTCART_CART_CHECKOUT') ?></a>
		</div>
	</div>
</div>
