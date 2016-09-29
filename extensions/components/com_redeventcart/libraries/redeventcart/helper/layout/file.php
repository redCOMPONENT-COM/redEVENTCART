<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('JPATH_PLATFORM') or die;

/**
 * Base class for rendering a display layout
 * loaded from from a layout file
 *
 * @since  1.0
 */
class RedeventcartHelperLayoutFile extends RLayoutFile
{
	/**
	 * Get the default array of include paths
	 *
	 * @return  array
	 */
	public function getDefaultIncludePaths()
	{
		$paths = parent::getDefaultIncludePaths();

		// Comes after redcore base layouts
		array_splice($paths, count($paths) - 2, 0, JPATH_LIBRARIES . '/redeventcart/layouts');

		// (lowest priority) custom defaultLayoutsPath
		if ($path = $this->options->get('defaultLayoutsPath'))
		{
			$paths[] = $path;
		}

		return $paths;
	}

	/**
	 * Refresh the list of include paths
	 *
	 * @return  void
	 */
	protected function refreshIncludePaths()
	{
		parent::refreshIncludePaths();

		// If method getDefaultIncludePaths does not exists we are in old Layout system
		if (version_compare(JVERSION, '3.0', '>') && version_compare(JVERSION, '3.5', '<'))
		{
			$customLayoutPath = JPATH_LIBRARIES . '/redeventcart/layouts';

			// If we already added the path, then do not add it again
			if ($this->includePaths[count($this->includePaths) - 2] != $customLayoutPath)
			{
				// Comes after redcore base layouts
				array_splice($this->includePaths, count($this->includePaths) - 2, 0, $customLayoutPath);
			}

			// (lowest priority) custom defaultLayoutsPath
			if ($path = $this->options->get('defaultLayoutsPath'))
			{
				$this->includePaths[] = $path;
			}
		}
	}
}
