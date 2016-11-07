<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
$collapsed = false;

//RHtmlMedia::loadFrameworkJs();

$sessionsParticipants = $this->cart->getSessionsParticipants();
$sessionsItems = $this->cart->getSessionsitems();

$isModal = JFactory::getApplication()->input->getInt('print');

$printOnClickOptions = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
$printOnclick = "window.open(this.href,'win2','" . $printOnClickOptions . "'); return false;";
$printHref = JRoute::_(RedeventcartHelperRoute::getReceiptRoute($this->cart->id) . '&tmpl=component&print=1');
?>
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

<div class="redeventcart receipt">
	<h3><?= $this->title ?></h3>

	<div class="intro">
		<?= $this->intro ?>
	</div>

	<?= $this->billing ?>

	<?php foreach ($this->cart->getSessionsParticipants() as $sessionId => $participants): ?>
		<?php $session = RedeventEntitySession::load($sessionId); ?>
		<?php $sessionItems = $sessionsItems[$sessionId]; ?>
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
					<?php
					foreach ($sessionItems->getItems() as $item): ?>
						<tr>
							<td><?= $item->getLabel() ?></td>
							<td><?= $item->getCount() ?></td>
							<td><?= RHelperCurrency::getFormattedPrice($item->getPriceVatIncluded(), $item->getCurrency()) ?></td>
							<td><?= RHelperCurrency::getFormattedPrice($item->getPriceVatIncluded() * $item->getCount(), $item->getCurrency()) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfooter>
					<tr>
						<td colspan="3" class="session-total"><?= JText::_('COM_REDEVENTCART_CART_RECEIPT_TOTAL_FOR_THIS_SESSION') ?></td>
						<td><?= RHelperCurrency::getFormattedPrice($sessionItems->getTotalPrice() + $sessionItems->getTotalVat(), $sessionItems->getCurrency()) ?></td>
					</tr>
				</tfooter>
			</table>

			<div class="panel-group" role="tablist" aria-multiselectable="true">
				<?php foreach ($participants as $participant):
					echo RedeventcartHelperLayout::render('redeventcart.receipt.participant', compact('participant'));
				endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="cart-footer">
		<div class="total">
			<div class="total-label"><?= JText::_('COM_REDEVENTCART_CART_TOTAL') ?></div>
			<div class="total-price"><?= RHelperCurrency::getFormattedPrice($this->cart->getTotalPrice() + $this->cart->getTotalVat(), $this->cart->getCurrency()) ?></div>
		</div>

		<?php if ($isModal): ?>
			<a href="#" class="btn btn-default print-button" onclick="window.print(); return false;" ><?= JText::_('COM_REDEVENTCART_CART_RECEIPT_CLICK_TO_PRINT') ?></a>
		<?php else: ?>
			<div class="buttons">
				<a href="#" class="btn btn-default"><?= JText::_('COM_REDEVENTCART_CART_GO_TO_MY_ACCOUNT') ?></a>
				<a href="<?= $printHref ?>" onclick="<?= $printOnclick ?>" class="btn btn-default"><?= JText::_('COM_REDEVENTCART_CART_PRINT_RECEIPT') ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>
