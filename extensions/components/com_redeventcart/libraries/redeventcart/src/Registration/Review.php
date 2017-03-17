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
class Review
{
	/**
	 * @var \RedeventcartEntityParticipant
	 */
	protected $participant;

	/**
	 * Edit constructor.
	 *
	 * @param   \RedeventcartEntityParticipant  $participant  participant
	 */
	public function __construct(\RedeventcartEntityParticipant $participant)
	{
		$this->participant = $participant;
	}

	/**
	 *  Get form html
	 *
	 * @return string html form
	 */
	public function getHtml()
	{
		try
		{
			if (!$submitter = $this->participant->getSubmitter())
			{
				throw new \LogicException('Participant submitter not found');
			}

			$answers = $submitter->getAnswers();
		}
		catch (\Exception $e)
		{
			\Redeventcart\Helper\Log::logException($e);

			return 'Error getting participant data';
		}

		return \RedeventcartHelperLayout::render(
			'redeventcart.cart.participant.review', array('id' => $this->participant->id, 'answers' => $answers)
		);
	}

	/**
	 * Get associated session
	 *
	 * @return \RedeventEntitySession
	 */
	private function getSession()
	{
		return $this->participant->getSession();
	}

	/**
	 * Check if a pricegroup is already selected
	 *
	 * @param   RedeventEntitySessionpricegroup[]  $sessionPriceGroups  session price groups
	 *
	 * @return RedeventEntitySessionpricegroup|false if not selected
	 */
	private function getSelectedPriceGroup($sessionPriceGroups)
	{
		if (count($sessionPriceGroups) == 1)
		{
			return current($sessionPriceGroups);
		}

		if ($this->participant->session_pricegroup_id)
		{
			foreach ($sessionPriceGroups as $sessionPriceGroup)
			{
				if ($sessionPriceGroup->id == $this->participant->session_pricegroup_id)
				{
					return $sessionPriceGroup;
				}
			}
		}

		return false;
	}

	/**
	 * Set price field
	 *
	 * @param   array  &$options  form options
	 *
	 * @return void
	 */
	private function setSessionPricefield(&$options)
	{
		// Multiple pricegroup handling
		$prices = $this->getSession()->getPricegroups(true);

		if (count($prices))
		{
			$selectedPricegroup = $this->getSelectedPriceGroup($prices);

			$field = new \RedeventRfieldSessionprice;
			$field->setOptions($prices);
			$field->setFormIndex(1);

			if ($selectedPricegroup)
			{
				$field->setValue($selectedPricegroup->id);
			}

			$options['extrafields'][1] = array($field);

			$currency = $selectedPricegroup ? $selectedPricegroup->currency : current($prices)->currency;
			$options['currency'] = $currency;
		}
	}
}
