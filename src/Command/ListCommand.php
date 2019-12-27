<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use Windwalker\Console\Command\Command;

/**
 * The RunCommand class.
 *
 * @since  {DEPLOY_VERSION}
 */
class ListCommand extends Command
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'list';

    /**
     * Property description.
     *
     * @var  string
     */
    protected $description = 'List task files.';

    /**
     * Property usage.
     *
     * @var  string
     */
    protected $usage = '%s <option>[option]</option>';

    /**
     * doExecute
     *
     * @return  boolean
     */
    protected function doExecute()
    {
        $files = glob(SB_TASKS . DIRECTORY_SEPARATOR . '*');

        $this->out()->out('Available files: ')
            ->out('-----------------------------------------');

        foreach ($files as $file) {
            $this->out(sprintf('<info>%s</info>', str_replace(SB_TASKS . DIRECTORY_SEPARATOR, '', $file)));
        }

        return true;
    }
}
