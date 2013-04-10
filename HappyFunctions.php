<?php

/*
 * This file is part of HappyField, a field parser for the Moon Framework.
 * See more at the GitHub page :
 * - Of this project @[ https://github.com/lambda2/Happy-Field ]
 * - Of the Moon project @[ https://github.com/lambda2/Moon ]
 *
 * ----------------------------------------------------------------------------
 * (c) 2013 Lambdaweb - www.lambdaweb.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happy;

/**
 * Will define a lot of basic functions
 * for validating the forms
 */
class HappyFunctions {


/******************************************************************************
 *                              Basic functions                               *
 ******************************************************************************/

	/**
	 * @return true if $expression is strictly greater than $value
	 */
	public static function sup($expression, $value)
	{
		return intval($expression) > $value;
	}

	/**
	 * @return true if $expression is strictly less than $value
	 */
	public static function inf($expression, $value)
	{
		return intval($expression) < $value;
	}

	/**
	 * @return true if $expression equals $value
	 */
	public static function equ($expression, $value)
	{
		return intval($expression) == $value;
	}



}




?>