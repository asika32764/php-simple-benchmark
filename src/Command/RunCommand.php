<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Benchmark;
use SimpleBenchmark\Task\AbstractTask;
use Windwalker\Console\Command\Command;

/**
 * The RunCommand class.
 *
 * @since  {DEPLOY_VERSION}
 */
class RunCommand extends Command
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'run';

    /**
     * Property description.
     *
     * @var  string
     */
    protected $description = 'Run benchmark';

    /**
     * Property usage.
     *
     * @var  string
     */
    protected $usage = '%s <cmd><task></cmd> [<cmd><times (10000)></cmd>] <option>[options]</option>';

    /**
     * doExecute
     *
     * @return  boolean
     *
     * @throws \Exception
     * @throws \Throwable
     */
    protected function doExecute()
    {
        $file = $this->getArgument(0) or $this->error(new \RuntimeException('Please enter task name.'));

        $target = SB_TASKS . '/' . $file;

        if (!is_file($file)) {
            $target .= '.php';
        }

        if (!is_file($target)) {
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

        $this->out()->out('<info>Benchmark Result</info>')
            ->out('---------------------------------------------')
            ->out('Run ' . number_format($times) . ' times')
            ->out()
            ->out($benchmark->render());

        return true;
    }
}
