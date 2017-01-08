<?php
/**
 * @package     Redeventcart.Module
 * @subpackage  Frontend.mod_redeventcart_cart
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

RHelperAsset::load('mod_redeventcart_cart.css', 'mod_redeventcart_cart');
RHelperAsset::load('mod_redeventcart_cart.js', 'mod_redeventcart_cart');

$participants = $cart->getParticipants();
$count = $participants ? count($participants) : 0;
?>
<div class="redeventcart-module">
	<a href="<?= JRoute::_(RedeventcartHelperRoute::getCartRoute()) ?>"><span class="icon icon-shopping-cart"></span><span class="count"><?= $count ? " ($count)" : '' ?></span></a>
	<div class="redeventcart-module-alert">
		<div class="button-close pull-right">
			<span class="icon-remove"></span>
		</div>

		<div class="redeventcart-module-alert-title">
			<?= JText::_('MOD_REDEVENTCART_CART_ADDED_TO_CART'); ?>
		</div>

		<div class="cart-alert-content"></div>

		<div class="go-to-cart">
			<a class="btn btn-primary" href="<?= JRoute::_(RedeventcartHelperRoute::getCartRoute()) ?>"><?= JText::_('MOD_REDEVENTCART_CART_GO_TO_CART'); ?></a>
		</div>
	</div>
</div>
