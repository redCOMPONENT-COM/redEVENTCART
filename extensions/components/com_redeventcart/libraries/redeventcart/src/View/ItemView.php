<?php
/**
 * @package     Redeventcart
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\View;

defined('_JEXEC') or die;

/**
 * Admin Item view.
 *
 * @since  1.0
 */
abstract class ItemView extends AdminView
{
	/**
	 * Display the category edit page
	 *
	 * @param   string  $tpl  The template file to use
	 *
	 * @return  string
	 */
	public function display($tpl = null)
	{
		$this->beforeDisplay();

		return parent::display($tpl);
	}

	/**
	 * Called before the view is displayed.
	 *
	 * @return  void
	 */
	protected function beforeDisplay()
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		if ($this->item)
		{
			$entityClass = 'RedeventcartEntity' . ucfirst($this->getName());

			if (class_exists($entityClass))
			{
				$this->entity = $entityClass::getInstance()->bind($this->item);
			}
		}
	}

	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		$subTitle = '';

		// For the edit layout we add the New or Edit sub title
		if ('edit' === $this->getLayout())
		{
			$subTitle = ' <small>' . \JText::_('COM_REDEVENTCART_NEW') . '</small>';

			if ($this->item->id)
			{
				$subTitle = ' <small>' . \JText::_('COM_REDEVENTCART_EDIT') . '</small>';
			}
		}

		return \JText::_(sprintf('COM_REDEVENTCART_%s_VIEW_TITLE', strtoupper($this->getName()))) . $subTitle;
	}

	/**
	 * Get the toolbar to render.
	 *
	 * @return  \RToolbar
	 */
	public function getToolbar()
	{
		$toolbar = new \RToolbar;

		$this->addSaveToolbarButton($toolbar);
		$this->addCancelToolbarButton($toolbar);

		return $toolbar;
	}

	/**
	 * Adds a save button to the toolbar.
	 *
	 * @param   \RToolbar  $toolbar  The toolbar
	 *
	 * @return  void
	 */
	protected function addSaveToolbarButton(\RToolbar $toolbar)
	{
		$user = \JFactory::getUser();
		$name = $this->getName();

		$applyTask = sprintf('%s.%s', $name, 'apply');
		$saveNewTask = sprintf('%s.%s', $name, 'save2new');
		$saveCopyTask = sprintf('%s.%s', $name, 'save2copy');
		$saveTask = sprintf('%s.%s', $name, 'save');

		$group = new \RToolbarButtonGroup;

		if ($user->authorise('core.create', 'com_redeventcart'))
		{
			$group->addButton(\RToolbarBuilder::createSaveButton($applyTask));
			$group->addButton(\RToolbarBuilder::createSaveAndNewButton($saveNewTask));
			$group->addButton(\RToolbarBuilder::createSaveAsCopyButton($saveCopyTask));
			$group->addButton(\RToolbarBuilder::createSaveAndCloseButton($saveTask));
		}

		$toolbar->addGroup($group);
	}

	/**
	 * Adds a cancel button to the toolbar.
	 *
	 * @param   \RToolbar  $toolbar  The toolbar
	 *
	 * @return  void
	 */
	protected function addCancelToolbarButton(\RToolbar $toolbar)
	{
		$task = sprintf('%s.%s', $this->getName(), 'cancel');

		$group = new \RToolbarButtonGroup;

		if (empty($this->item->id))
		{
			$group->addButton(\RToolbarBuilder::createCancelButton($task));
		}

		else
		{
			$group->addButton(\RToolbarBuilder::createCloseButton($task));
		}

		$toolbar->addGroup($group);
	}
}
