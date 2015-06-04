<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Application;

use Windwalker\Console\Console;

/**
 * The Application class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Application extends Console
{
	protected $name = 'PHP Simple Benchmark Framework';

	protected $description = 'Help of Simple Benchmark.';

	protected $help = <<<HELP
Use `<cmd>benchmark list</cmd>` to list all tasks.

Use `<cmd>benchmark create TaskName</cmd>` to generate a new task sample file to /tasks folder.

Use `<cmd>benchmark run TaskName [times]</cmd>` to run benchmark
HELP;

}
