<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Application;

use Windwalker\Console\Console;
use Windwalker\Console\IO\IOInterface;
use Windwalker\Structure\Structure;

/**
 * The Application class.
 *
 * @since  {DEPLOY_VERSION}
 */
class Application extends Console
{
    protected $version = null;

    protected $title = 'PHP Simple Benchmark Framework';

    protected $description = 'Help of Simple Benchmark.';

    protected $help = <<<HELP
Use `<cmd>benchmark create TaskName</cmd>` to generate a new task sample file to /tasks folder.

Use `<cmd>benchmark run TaskFile.php [times]</cmd>` to run benchmark
HELP;

    /**
     * Application constructor.
     *
     * @param  IOInterface|null  $io
     * @param  Structure|null    $config
     */
    public function __construct(IOInterface $io = null, Structure $config = null)
    {
        $this->version = trim(file_get_contents(__DIR__ . '/../../VERSION'));

        parent::__construct($io, $config);
    }
}
