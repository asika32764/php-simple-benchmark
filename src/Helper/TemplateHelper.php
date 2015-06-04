<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Helper;

/**
 * The TemplateHelper class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class TemplateHelper
{
	/**
	 * Parse variable and replace it. This method is a simple template engine.
	 *
	 * Example: The {{ foo.bar.yoo }} will be replace to value of `$data['foo']['bar']['yoo']`
	 *
	 * @param   string $string The template to replace.
	 * @param   array  $data   The data to find.
	 * @param   array  $tags   The variable tags.
	 *
	 * @return  string Replaced template.
	 */
	public static function parseVariable($string, $data = array(), $tags = array('{{', '}}'))
	{
		$defaultTags = array('{{', '}}');

		$tags = (array) $tags + $defaultTags;

		list($begin, $end) = $tags;

		$regex = preg_quote($begin) . '\s*(.+?)\s*' . preg_quote($end);

		return preg_replace_callback(
			chr(1) . $regex . chr(1),
			function($match) use ($data)
			{
				$return = static::getByPath($data, $match[1]);
				if (is_array($return) || is_object($return))
				{
					return print_r($return, 1);
				}
				else
				{
					return $return;
				}
			},
			$string
		);
	}

	/**
	 * Get data from array or object by path.
	 *
	 * Example: `ArrayHelper::getByPath($array, 'foo.bar.yoo')` equals to $array['foo']['bar']['yoo'].
	 *
	 * @param mixed  $data      An array or object to get value.
	 * @param mixed  $paths     The key path.
	 * @param string $separator Separator of paths.
	 *
	 * @return  mixed Found value, null if not exists.
	 *
	 * @since   2.0
	 */
	public static function getByPath($data, $paths, $separator = '.')
	{
		if (empty($paths))
		{
			return null;
		}

		$args = is_array($paths) ? $paths : explode($separator, $paths);
		$dataTmp = $data;

		foreach ($args as $arg)
		{
			if (is_object($dataTmp) && isset($dataTmp->$arg))
			{
				$dataTmp = $dataTmp->$arg;
			}
			elseif (is_array($dataTmp) && isset($dataTmp[$arg]))
			{
				$dataTmp = $dataTmp[$arg];
			}
			else
			{
				return null;
			}
		}

		return $dataTmp;
	}
}
