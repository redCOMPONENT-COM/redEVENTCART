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
 * Edit registration class
 *
 * @since  1.0
 */
class Edit
{
	/**
	 * @var \RedeventcartEntityParticipant
	 */
	private $participant;

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
	public function getForm()
	{
		$session = $this->participant->getSession();
		$form_id = $session->getEvent()->getEventtemplate()->redform_id;
		$reference = $this->participant->submitter_id ? array($this->participant->submitter_id) : false;

		$rfcore = \RdfCore::getInstance($form_id);

		$options = array('extrafields' => array());
		$options['sessionId'] = $session->id;
		$options['eventId'] = $session->eventid;

		$this->setSessionPricefield($options);

		$fieldsHtml = $rfcore->getFormFields($form_id, $reference, 1, $options);

		return \RedeventcartHelperLayout::render('redeventcart.participant.form', array('id' => $this->participant->id, 'fieldsHtml' => $fieldsHtml));
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
