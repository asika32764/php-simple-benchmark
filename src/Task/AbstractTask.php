<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Task;

use Windwalker\Profiler\Benchmark;

/**
 * The AbstractTask class.
 * 
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractTask
{
	/**
	 * Property benchmark.
	 *
	 * @var  Benchmark
	 */
	protected $benchmark;

	/**
	 * Class init.
	 *
	 * @param Benchmark $benchmark
	 */
	public function __construct(Benchmark $benchmark)
	{
		$this->benchmark = $benchmark ? : new Benchmark;
	}

	/**
	 * execute
	 *
	 * @param   int  $times
	 *
	 * @return  void
	 */
	public function execute($times)
	{
		$this->doExecute($this->benchmark);

		$this->benchmark->execute($times);
	}

	/**
	 * doExecute
	 *
	 * @param Benchmark $benchmark
	 *
	 * @return  void
	 */
	abstract protected function doExecute(Benchmark $benchmark);

	/**
	 * Method to get property Benchmark
	 *
	 * @return  Benchmark
	 */
	public function getBenchmark()
	{
		return $this->benchmark;
	}

	/**
	 * Method to set property benchmark
	 *
	 * @param   Benchmark $benchmark
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setBenchmark($benchmark)
	{
		$this->benchmark = $benchmark;

		return $this;
	}
}
