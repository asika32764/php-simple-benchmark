<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Helper\TemplateHelper;
use Windwalker\Console\Command\Command;

/**
 * The RunCommand class.
 *
 * @since  {DEPLOY_VERSION}
 */
class CreateCommand extends Command
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'create';

    /**
     * Property description.
     *
     * @var  string
     */
    protected $description = 'Create a task file.';

    /**
     * Property usage.
     *
     * @var  string
     */
    protected $usage = '%s <cmd><task name></cmd> <option>[option]</option>';

    /**
     * doExecute
     *
     * @return  boolean
     */
    protected function doExecute()
    {
        $name = $this->getArgument(0);

        if (!$name) {
            throw new \InvalidArgumentException('Please enter a task name.');
        }

        $dest = new \SplFileInfo(SB_TASKS . '/' . $name . '.php');

        if ($dest->isFile()) {
            throw new \RuntimeException(sprintf('File %s has exists.', $dest->getBasename()));
        }

        $template = file_get_contents(SB_ROOT . '/resources/templates/task_template.tpl');

        $template = TemplateHelper::parseVariable($template, array('task_name' => $name));

        file_put_contents($dest->getPathname(), $template);

        $this->out('Written file at: ' . $dest->getPathname());

        return true;
    }
}
