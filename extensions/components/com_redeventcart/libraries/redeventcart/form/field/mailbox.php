<?php
/**
 * @package     Redeventcart
 * @subpackage  Library
 *
 * @copyright   Copyright (C) 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

/**
 * redeventcart item Field
 *
 * @since  1.0
 */
class RedeventcartFormFieldItem extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var  string
	 */
	public $type = 'item';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('id AS value, name AS text')
			->from('#__redeventcart_item')
			->order('name');

		$db->setQuery($query);
		$res = $db->loadObjectList();

		return ($res ? array_merge(parent::getOptions(), $res) : parent::getOptions());
	}
}
