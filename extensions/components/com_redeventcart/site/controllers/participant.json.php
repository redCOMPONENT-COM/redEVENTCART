<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Participant  ajax controller
 *
 * @since  1.0.0
 */
class RedeventcartControllerParticipant extends JControllerLegacy
{
	/**
	 * Delete a participant
	 *
	 * @return void
	 */
	public function delete()
	{
		try
		{
			if (!$id = $this->input->getInt('id'))
			{
				throw new InvalidArgumentException(JText::_('COM_REDEVENTCART_PARTICIPANT_ID_REQUIRED'));
			}

			$model = $this->getModel('participant');
			$ids = array($id);

			if (!$model->delete($ids))
			{
				throw new RuntimeException($model->getError());
			}

			echo new JResponseJson(array('removed_id' => $id));
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}

	/**
	 * Save participant
	 *
	 * @return void
	 */
	public function save()
	{
		try
		{
			if (!$id = $this->input->getInt('id'))
			{
				throw new InvalidArgumentException(JText::_('COM_REDEVENTCART_PARTICIPANT_SAVE_ID_REQUIRED'));
			}

			$participant = RedeventcartEntityParticipant::load($id);
			$session = $participant->getSession();

			$status = RedeventHelper::canRegister($session->id);

			if (!$status->canregister)
			{
				throw new RuntimeException($status->status);
			}

			// Get prices associated to pricegroups
			$currency = null;

			$options = array();
			$extrafields = array();

			if ($pricegroups = $session->getPricegroups())
			{
				if (!$regPricegroup = $this->input->getInt('sessionprice_1'))
				{
					throw new RuntimeException(JText::_('COM_REDEVENTCART_PARTICIPANT_SAVE_MISSING_PRICE'));
				}

				$field = $session->getPricefield();
				$field->setValue($regPricegroup);
				$field->setFormIndex(1);

				$extrafields[1] = array($field);

				$options['extrafields'] = $extrafields;
				$options['currency'] = $session->getEvent()->getForm()->currency;
			}

			$redformHelper = new RdfCoreFormSubmission;
			$data = array();

			if ($submitterId = $participant->submitter_id)
			{
				$submitter = RdfEntitySubmitter::load($submitterId);
				$data['submitter_id1'] = $submitterId;
				$redformHelper->setSubmitKey($submitter->submit_key);
			}

			$result = $redformHelper->apisaveform('redeventcart', $options, $data);

			// Redform saved fine, now store participant
			$submitterId = $result->posts[0]['sid'];
			$participant->session_pricegroup_id = $regPricegroup;
			$participant->submitter_id = $submitterId;

			$userHelper = new RdfAnswersUser;

			if ($user = $userHelper->getFromSubmitterId($submitterId))
			{
				$participant->user_id = $user->id;
			}
			elseif ($session->getEvent()->getEventtemplate()->juser)
			{
				if ($new = $userHelper->createFromSubmitterId($result->posts[0]['sid']))
				{
					$participant->user_id = $new->id;
				}
			}

			$participant->save();

			echo new JResponseJson(array('submitter_id' => $submitterId));
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}
}
