<?php
/**
 * @package     Redeventcart.Libraries
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redeventcart\Cart;

defined('JPATH_BASE') or die;

/**
 * Utility class for cart price items
 *
 * @package  Redeventcart.Libraries
 * @since    1.0
 */
class Item
{
	/**
	 * @var int
	 */
	private $count = 0;

	/**
	 * @var string
	 */
	private $currency;

	/**
	 * @var string
	 */
	private $label;

	/**
	 * @var float
	 */
	private $price;

	/**
	 * @var string
	 */
	private $sku;

	/**
	 * @var float
	 */
	private $vat;

	/**
	 * Item constructor.
	 *
	 * @param   array  $params  init parameters
	 */
	public function __construct($params = array())
	{
		if (isset($params['currency']))
		{
			$this->currency = $params['currency'];
		}

		if (isset($params['count']))
		{
			$this->count = $params['count'];
		}

		if (isset($params['label']))
		{
			$this->label = $params['label'];
		}

		if (isset($params['price']))
		{
			$this->price = $params['price'];
		}

		if (isset($params['sku']))
		{
			$this->sku = $params['sku'];
		}

		if (isset($params['vat']))
		{
			$this->vat = $params['vat'];
		}
	}

	/**
	 * Increment count
	 *
	 * @param   int  $count  count
	 *
	 * @return $this
	 */
	public function add($count = 1)
	{
		$this->count += $count;
	}

	/**
	 * Get count
	 *
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * Get count
	 *
	 * @return int
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * Get currency
	 *
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * Get price
	 *
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * Get price vat excluded
	 *
	 * @return float
	 */
	public function getPriceVatExcluded()
	{
		return $this->getPrice();
	}

	/**
	 * Get price vat included
	 *
	 * @return float
	 */
	public function getPriceVatIncluded()
	{
		return $this->getPrice() + $this->getCalculatedVat();
	}

	/**
	 * Get calculated vat
	 *
	 * @return float
	 */
	public function getCalculatedVat()
	{
		return $this->vat ? $this->getPrice() * $this->vat : 0;
	}

	/**
	 * Get sku
	 *
	 * @return string
	 */
	public function getSku()
	{
		return $this->sku;
	}

	/**
	 * Get vat
	 *
	 * @return float
	 */
	public function getVat()
	{
		return $this->vat;
	}

	/**
	 * Set label
	 *
	 * @param   string  $label  label
	 *
	 * @return $this
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * Set count
	 *
	 * @param   int  $count  count
	 *
	 * @return $this
	 */
	public function setCount($count)
	{
		$this->count = $count;
	}

	/**
	 * Set Price
	 *
	 * @param   float  $price  price
	 *
	 * @return $this
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * Set SKU
	 *
	 * @param   string  $sku  sku
	 *
	 * @return $this
	 */
	public function setSku($sku)
	{
		$this->sku = $sku;
	}

	/**
	 * Set vat
	 *
	 * @param   float  $vat  cat
	 *
	 * @return $this
	 */
	public function setVat($vat)
	{
		$this->vat = $vat;
	}

	/**
	 * Set currency
	 *
	 * @param   string  $currency  currency
	 *
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;
	}
}
