<?php
/**
 * @package    Redeventcart.Plugin
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

extract($displayData);
?>
<form action="<?php echo JRoute::_('index.php?option=com_redmember&task=rmlogin.login'); ?>"
      method="post" name="redmember-login" id="redmember-login">
	<p id="com-form-login-username">
		<label for="username"><?php echo JText::_('COM_REDMEMBER_RMLOGIN_USERNAME') ?></label><br/>
		<input name="username" id="username" type="text" class="inputbox" alt="username" size="18"/>
	</p>

	<p id="com-form-login-password">
		<label for="password"><?php echo JText::_('COM_REDMEMBER_RMLOGIN_PASSWORD') ?></label><br/>
		<input type="password" id="password" name="password" class="inputbox" size="18" alt="password"/>
	</p>
	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<p id="com-form-login-remember">
			<label for="remember"><?php echo JText::_('COM_REDMEMBER_RMLOGIN_REMEMBER') ?></label>
			<input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" alt="Remember Me"/>
		</p>
	<?php endif; ?>
	<input type="submit" name="Submit" class="button" value="<?php echo JText::_('COM_REDMEMBER_RMLOGIN_LOGIN') ?>"/>
	<ul>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
				<?php echo JText::_('COM_REDMEMBER_RMLOGIN_FORGOT_YOUR_PASSWORD'); ?>
			</a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
				<?php echo JText::_('COM_REDMEMBER_RMLOGIN_FORGOT_YOUR_USERNAME'); ?>
			</a>
		</li>
	</ul>
	<input type="hidden" name="option" value="com_redmember"/>
	<input type="hidden" name="task" value="rmlogin.login"/>
	<input type="hidden" name="return" value="<?php echo $return; ?>"/>
	<?php echo JHTML::_('form.token'); ?>
</form>
