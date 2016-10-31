<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\Registration;

defined('JPATH_BASE') or die;

/**
 * Review participant registration class
 *
 * @since  1.0
 */
class Receipt extends Review
{
	/**
	 *  Get form html
	 *
	 * @return string html form
	 */
	public function getHtml()
	{
		$answers = $this->participant->getSubmitter()->getAnswers();

		return \RedeventcartHelperLayout::render(
			'redeventcart.cart.participant.receipt', array('id' => $this->participant->id, 'answers' => $answers)
		);
	}
}
