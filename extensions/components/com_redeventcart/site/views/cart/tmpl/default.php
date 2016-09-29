<?php
/**
 * @package    Redeventcart.Site
 *
 * @copyright  Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');
?>
<h3><?= $this->title ?></h3>

<?= $this->intro ?>

<?php echo '<pre>'; echo print_r($this->items, true); echo '</pre>';
