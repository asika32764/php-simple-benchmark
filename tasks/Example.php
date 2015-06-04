<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 Lyra Soft. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

/**
 * The Example task.
 */
class Example extends \SimpleBenchmark\Task\AbstractTask
{
	/**
	 * Run your benchmark here.
	 *
	 * @param   \Windwalker\Profiler\Benchmark  $benchmark
	 *
	 * @return  void
	 */
	protected function doExecute(\Windwalker\Profiler\Benchmark $benchmark)
	{
		$benchmark->addTask('task1-md5', function()
		{
			md5(uniqid());

		})->addTask('task2-sha1', function()
		{
			sha1(uniqid());
		});
	}
}
