<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Cart ajax controller
 *
 * @since  1.0.0
 */
class RedeventcartControllerCart extends JControllerLegacy
{
	/**
	 * Add session to cart
	 *
	 * @return void
	 */
	public function addsession()
	{
		try
		{
			$app = JFactory::getApplication();

			$session = RedeventEntitySession::load($this->input->getInt('id'));

			if (!$session->isValid())
			{
				throw new InvalidArgumentException('Missing or invalid session id');
			}

			$currentCart = $app->getUserState('redeventcart.cart', array());

			JPluginHelper::getPlugin('redeventcart');
			$error = array();
			RFactory::getDispatcher()->trigger('onRedeventcartCheckAddSession', array($currentCart, $session, &$error));

			if (!empty($error))
			{
				throw new InvalidArgumentException(implode("\n", $error));
			}

			if (!isset($currentCart[$session->id]))
			{
				$currentCart[$session->id] = array("id" => $session->id, "participants" => 1);
			}
			else
			{
				$currentCart[$session->id]["participants"]++;
			}

			$app->setUserState('redeventcart.cart', $currentCart);

			echo new JResponseJson($currentCart);
		}
		catch (Exception $e)
		{
			echo new JResponseJson($e);
		}
	}
}
