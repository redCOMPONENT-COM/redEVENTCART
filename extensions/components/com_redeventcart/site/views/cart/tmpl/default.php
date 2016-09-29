<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
?>
<h3><?= Jtext::_('COM_REDEVENTCART_VIEW_TITLE_MY_ITEMS') ?></h3>

<?= $this->intro ?>

<table class="table redeventcart-items">
	<thead>
		<tr>
			<th><?= JText::_('COM_REDEVENTCART_VIEW_ITEMS_COL_NAME') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($this->items): ?>
			<?php foreach ($this->items as $c): ?>
				<tr>
					<td><?= JHtml::link(RedeventcartHelperRoute::getItemRoute($c->id), $c->name) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
