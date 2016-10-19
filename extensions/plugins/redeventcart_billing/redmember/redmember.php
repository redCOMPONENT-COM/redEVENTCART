<?php
/**
 * @package    Redeventcart.Plugin
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::import('redevent.bootstrap');
RedeventBootstrap::bootstrap();

/**
 * Redeventcart billing plugin for redmember integration
 *
 * @since  1.0.0
 */
final class PlgRedeventcart_BillingRedmember extends JPlugin
{
	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Return html for existing customer
	 *
	 * @param   string  &$html  html for output
	 *
	 * @return void
	 *
	 * @since 1.0
	 */
	public function onRedeventcartBillingGetexisting(&$html)
	{
		$rmUser = RedmemberApi::getUser(JFactory::getUser()->get('id'));

		if ($rmUser->guest == 1)
		{
			$html = $this->getLoginForm();
		}
		else
		{
			$html = $this->getCurrentUserForm();
		}
	}

	/**
	 * Return html for new customer
	 *
	 * @param   string  &$html  html for output
	 *
	 * @return void
	 *
	 * @since 1.0
	 */
	public function onRedeventcartBillingCreatenew(&$html)
	{
		$html = "Please create an account first";
	}

	/**
	 * Handle save callback
	 *
	 * @return void
	 *
	 * @since 1.0
	 */
	public function onAjaxSaveBilling()
	{
		JSession::checkToken('post') or jexit(JText::_('JInvalid_Token'));

		$app = JFactory::getApplication();
		$input = $app->input;

		$user = JFactory::getUser();

		try
		{
			if ($user->guest)
			{
				throw new RuntimeException('invalid user');
			}

			$entity = RedeventcartEntityBilling::getInstance();
			$cart = RedeventcartEntityCart::getCurrentInstance();
			$cart->clearBilling();

			$entity->save(
				array(
					'cart_id' => $cart->id,
					'plugin' => 'redmember',
					'reference' => $user->id
				)
			);

			$app->redirect(RedeventcartHelperRoute::getReviewRoute());
		}
		catch (Exception $e)
		{
			$app->enqueueMessage($e->getMessage(), 'error');
			$app->redirect(RedeventcartHelperRoute::getBillingRoute());
		}
	}

	private function getCurrentUserForm()
	{
		return RedeventcartHelperLayout::render('redeventcart.billing.redmember.currentuserform', compact('return'), '', array('defaultLayoutsPath' => __DIR__ . '/layouts'));
	}

	private function getLoginForm()
	{
		$return = base64_encode(JUri::current());

		return RedeventcartHelperLayout::render('redeventcart.billing.redmember.login', compact('return'), '', array('defaultLayoutsPath' => __DIR__ . '/layouts'));
	}
}
