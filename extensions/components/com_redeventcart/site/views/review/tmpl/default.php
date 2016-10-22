<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

RHtmlMedia::loadFrameworkJs();
RHelperAsset::load('reviewview.js');
RHelperAsset::load('cartview.css');
$isCollapsed = false;
?>
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

<div class="redeventcart review">
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
					<th><?= JText::_('COM_REDEVENTCART_CART_ITEMS') ?></th>
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
					echo RedeventcartHelperLayout::render('redeventcart.cart.participantreview', compact('participant', 'i', 'isCollapsed'));
					$i++;
					$isCollapsed = true;
				endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="cart-footer">
		<div class="total">
			<div class="total-label"><?= JText::_('COM_REDEVENTCART_CART_TOTAL') ?></div>
			<div class="total-price"></div>
		</div>

		<div class="checkout">
			<a href="<?= JRoute::_('index.php?option=com_redeventcart&task=cart.payment'); ?>" class="btn btn-default"><?= JText::_('COM_REDEVENTCART_CART_PLACE_ORDER') ?></a>
		</div>
	</div>
</div>
