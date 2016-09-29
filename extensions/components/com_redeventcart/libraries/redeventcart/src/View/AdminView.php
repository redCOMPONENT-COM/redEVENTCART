<?php
/**
 * @package     Redeventcart
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\View;

defined('_JEXEC') or die;

/**
 * Base Admin view.
 *
 * @since  1.0
 */
abstract class AdminView extends \RViewAdmin
{
	/**
	 * The component title to display in the topbar layout (if using it).
	 * It can be html.
	 *
	 * @var string
	 */
	protected $componentTitle = 'red<strong>XYZ</strong>';

	/**
	 * Do we have to display a sidebar ?
	 *
	 * @var  boolean
	 */
	protected $displaySidebar = true;

	/**
	 * The sidebar layout name to display.
	 *
	 * @var  boolean
	 */
	protected $sidebarLayout = 'sidebar';

	/**
	 * Do we have to display a topbar ?
	 *
	 * @var  boolean
	 */
	protected $displayTopBar = true;

	/**
	 * The topbar layout name to display.
	 *
	 * @var  boolean
	 */
	protected $topBarLayout = 'topbar';

	/**
	 * Do we have to display a topbar inner layout ?
	 *
	 * @var  boolean
	 */
	protected $displayTopBarInnerLayout = true;

	/**
	 * The topbar inner layout name to display.
	 *
	 * @var  boolean
	 */
	protected $topBarInnerLayout = 'topnav';

	/**
	 * True to display "Back to Joomla" link (only if displayJoomlaMenu = false)
	 *
	 * @var  boolean
	 */
	protected $displayBackToJoomla = false;

	/**
	 * True to display "Version 1.0.x"
	 *
	 * @var  boolean
	 */
	protected $displayComponentVersion = true;

	/**
	 * Redirect to another location
	 *
	 * @var  string
	 */
	protected $logoutReturnUri = 'index.php';

	/**
	 * Constructor
	 *
	 * @param   array  $config  A named configuration array for object construction.<br/>
	 *                          name: the name (optional) of the view (defaults to the view class name suffix).<br/>
	 *                          charset: the character set to use for display<br/>
	 *                          escape: the name (optional) of the function to use for escaping strings<br/>
	 *                          base_path: the parent path (optional) of the views directory (defaults to the component folder)<br/>
	 *                          template_plath: the path (optional) of the layout directory (defaults to base_path + /views/ + view name<br/>
	 *                          helper_path: the path (optional) of the helper files (defaults to base_path + /helpers/)<br/>
	 *                          layout: the layout (optional) to use to display the view<br/>
	 */
	public function __construct($config = array())
	{
		// If user is Super Admin (or has permission to manage the core component, enables Back2Joomla link)
		if (\JFactory::getApplication()->isAdmin())
		{
			$this->displayBackToJoomla = true;
		}

		parent::__construct($config);

		\RHelperAsset::load('redeventcart.backend.css', 'com_redeventcart');

		$this->sidebarData = array(
			'active' => strtolower($this->_name),
			'view' => $this
		);
	}

	/**
	 * Get the page title
	 *
	 * @return  string  The title to display
	 */
	public function getTitle()
	{
		return \JText::_(sprintf('COM_REDEVENTCART_%s_VIEW_TITLE', strtoupper($this->getName())));
	}
}
