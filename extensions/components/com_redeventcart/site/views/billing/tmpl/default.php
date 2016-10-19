<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
$collapsed = false;

RHtmlMedia::loadFrameworkJs();
$loggedIn = !$this->user->guest;
?>
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

<div class="redeventcart billing">
	<h3><?= $this->title ?></h3>

	<div class="intro">
		<?= $this->intro ?>
	</div>

	<div class="panel-group" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading <?= $submitted ? 'submitted' : ''; ?>" role="tab" id="heading_existing">
				<div class="row">
					<div class="col-md-12">
						<h4 class="panel-title">
							<?php $class = $loggedIn ? '' : 'class="collapsed"'; ?>
							<span class="indicator icon-<?= $loggedIn ? 'chevron-down' : 'chevron-right' ?> "></span>
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-existing" aria-expanded="true" aria-controls="collapse-existing" <?= $class ?>>
								<?= JText::_('COM_REDEVENTCART_BILLING_EXISTING_CUSTOMER'); ?>
							</a>
						</h4>
					</div>
				</div>
			</div>
			<?php $in = $loggedIn ? 'in' : ''; ?>
			<div id="collapse-existing" class="panel-collapse collapse <?= $in ?>" role="tabpanel" aria-labelledby="heading_existing">
				<div class="panel-body">
					<?php
					$loginHtml = '';
					$this->dispatcher->trigger('onRedeventcartBillingGetexisting', array(&$loginHtml));
					echo $loginHtml;
					?>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading <?= $submitted ? 'submitted' : ''; ?>" role="tab" id="heading_new">
				<div class="row">
					<div class="col-md-12">
						<h4 class="panel-title">
							<?php $class = $loggedIn ? 'class="collapsed"' : ''; ?>
							<span class="indicator icon-<?= $loggedIn ? 'chevron-right' : 'chevron-down' ?> "></span>
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-new" aria-expanded="true" aria-controls="collapse-new" <?= $class ?>>
								<?= JText::_('COM_REDEVENTCART_BILLING_NEW_CUSTOMER'); ?>
							</a>
						</h4>
					</div>
				</div>
			</div>
			<?php $in = $loggedIn ? '' : 'in'; ?>
			<div id="collapse-new" class="panel-collapse collapse <?= $in ?>" role="tabpanel" aria-labelledby="heading_new">
				<div class="panel-body">
					<?php
					$newHtml = '';
					$this->dispatcher->trigger('onRedeventcartBillingCreatenew', array(&$newHtml));
					echo $newHtml;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
