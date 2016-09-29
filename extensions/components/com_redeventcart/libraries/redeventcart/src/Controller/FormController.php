<?php
/**
 * @package     Redeventcart
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\Controller;

defined('_JEXEC') or die;

/**
 * Base controller for forms.
 *
 * @since  1.0
 */
abstract class FormController extends \RControllerForm
{
	/**
	 * Task to come back to the list view.
	 *
	 * @return  void
	 */
	public function backToList()
	{
		$this->setRedirect(
			$this->getRedirectToListRoute($this->getRedirectToListAppend())
		);
	}

	/**
	 * Refreshes the form.
	 *
	 * @return  void
	 */
	public function refreshForm()
	{
		$app = \JFactory::getApplication();
		$recordId = $app->input->getInt('id', 0);
		$data = $app->input->post->get('jform', array(), 'array');
		$context = "$this->option.edit.$this->context";

		$app->setUserState($context . '.data', $data);
		$this->setRedirect($this->getRedirectToItemRoute($this->getRedirectToItemAppend($recordId)));
	}
}
