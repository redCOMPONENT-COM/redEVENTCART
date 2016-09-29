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
 * Admin List view.
 *
 * @since  1.0
 */
abstract class ListView extends AdminView
{
	/**
	 * Display the template list
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
		// Check for errors
		$errors = $this->get('Errors');

		if (count($errors))
		{
			\JError::raiseError(500, implode("\n", $errors));

			return;
		}

		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->filterForm = $this->get('Form');
		$this->activeFilters = $this->get('ActiveFilters');
	}
}
