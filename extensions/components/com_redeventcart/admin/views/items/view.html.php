<?php
/**
 * @package    Redeventcart.Backend
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Items view for redeventcart.
 *
 * @since  1.0
 */
class RedeventcartViewItems extends Redeventcart\View\ListView
{
	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		return JText::_('COM_REDEVENTCART_ITEM_LIST_TITLE');
	}

	/**
	 * Get the toolbar to render.
	 *
	 * @return  RToolbar
	 */
	public function getToolbar()
	{
		$user = JFactory::getUser();

		$firstGroup = new RToolbarButtonGroup;

		// Add / edit
		if ($user->authorise('core.create', 'com_redeventcart'))
		{
			$new = RToolbarBuilder::createNewButton('item.add');
			$firstGroup->addButton($new);
		}

		if ($user->authorise('core.edit', 'com_redeventcart'))
		{
			$edit = RToolbarBuilder::createEditButton('item.edit');
			$firstGroup->addButton($edit);
		}

		// Delete / Trash
		if ($user->authorise('core.delete', 'com_redeventcart'))
		{
			$delete = RToolbarBuilder::createDeleteButton('items.delete');
			$firstGroup->addButton($delete);
		}

		$toolbar = new RToolbar;
		$toolbar->addGroup($firstGroup);

		return $toolbar;
	}
}
