<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\Helper;

defined('JPATH_BASE') or die;

/**
 * Log class
 *
 * @since  1.0
 */
abstract class Log
{
	/**
	 * Log a message
	 *
	 * @param   string  $message  message
	 * @param   int     $type     type
	 *
	 * @return void
	 */
	public static function logMessage($message, $type = \JLog::INFO)
	{
		\JLog::addLogger(
			array(
				'text_file' => 'com_redeventcart.errors.php'
			),
			\JLog::ALL,
			array('com_redeventcart')
		);

		\JLog::add(
			$message,
			$type,
			'com_redeventcart'
		);
	}

	/**
	 * Log an exception
	 *
	 * @param   Exception  $e  exception
	 *
	 * @return void
	 */
	public static function logException($e)
	{
		self::logMessage($e->getMessage() . ': ' . static::getLogMessageFromException($e), \JLog::ERROR);
	}

	/**
	 * Convert string to one line
	 *
	 * @param   string  $str  string
	 *
	 * @return string
	 */
	private static function convertStringToOneLine($str)
	{
		return str_replace(array("\n", "<br/>"), ', ', $str);
	}

	/**
	 * Get message from exception for logging
	 *
	 * @param   Exception  $e  exception
	 *
	 * @return string
	 */
	private static function getLogMessageFromException($e)
	{
		return $e->getMessage() . ': ' . static::convertStringToOneLine($e->getTraceAsString());
	}
}
