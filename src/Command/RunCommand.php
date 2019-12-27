<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Benchmark;
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
        $file = $this->getArgument(0) or $this->error(new \RuntimeException('Please enter task file.'));

        if (!is_file($file)) {
            throw new \RuntimeException(sprintf('File %s not exists', $file));
        }

        $target = new \SplFileInfo($file);

        $benchmark = new Benchmark($target->getBasename('.php'));

        include $target->getPathname();

        $times = $this->getArgument(1, 10000);

        $benchmark->execute($times);

        $this->out()->out('<info>Benchmark Result</info>')
            ->out('---------------------------------------------')
            ->out('Run ' . number_format($times) . ' times')
            ->out()
            ->out($benchmark->render());

        return true;
    }
}
