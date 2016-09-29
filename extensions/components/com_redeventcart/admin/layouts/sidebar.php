<?php
/**
 * @package    Redeventcart.Backend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$data = $displayData;

$active = null;

if (isset($data['active']))
{
	$active = $data['active'];
}

$itemsClass = ($active === 'items') ? 'active' : '';
$optionsClass = ($active === 'config') ? 'active' : '';

$user = JFactory::getUser();

$uri = JUri::getInstance();
$return = base64_encode('index.php' . $uri->toString(array('query')));
?>

<ul class="nav nav-tabs nav-stacked">
	<li>
		<a class="<?php echo $itemsClass; ?>"
		   href="<?php echo JRoute::_('index.php?option=com_redeventcart&view=items') ?>">
			<i class="icon-list"></i>
			<?php echo JText::_('COM_REDEVENTCART_ITEM_LIST_TITLE') ?>
		</a>
	</li>
	<?php if ($user->authorise('core.admin', 'com_redeventcart')): ?>
	<li>
		<a class="<?php echo $optionsClass; ?>"
		   href="<?php echo JRoute::_('index.php?option=com_redcore&view=config&layout=edit&component=com_redeventcart&return=' . $return); ?>">
			<i class="icon-cogs"></i>
			<?php echo JText::_('JToolbar_Options') ?>
		</a>
	</li>
	<?php endif; ?>
</ul>
