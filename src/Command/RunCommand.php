<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Task\AbstractTask;
use Windwalker\Console\Command\Command;
use Windwalker\Profiler\Benchmark;

/**
 * The RunCommand class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class RunCommand extends Command
{
	protected $name = 'run';

	protected $description = 'Run benchmark';

	protected function doExecute()
	{
		$file = $this->getArgument(0) or $this->error(new \RuntimeException('Please enter task name.'));

		$target = SB_TASKS . '/' . $file;

		if (!is_file($file))
		{
			$target .= '.php';
		}

		if (!is_file($target))
		{
			throw new \RuntimeException(sprintf('File %s not exists', $target));
		}

		$target = new \SplFileInfo($target);

		require_once $target->getPathname();

		$class = $target->getBasename('.php');

		/** @var AbstractTask $task */
		$task = new $class(new Benchmark($class));

		$times = $this->getArgument(1, 10000);

		$task->execute($times);

		$benchmark = $task->getBenchmark();

		$this->out($benchmark->render());

		return true;
	}

	/**
	 * error
	 *
	 * @param \Exception $exception
	 *
	 * @return  void
	 *
	 * @throws \Exception
	 */
	protected function error(\Exception $exception)
	{
		throw $exception;
	}
}
