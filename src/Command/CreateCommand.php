<?php

/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Helper\TemplateHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The RunCommand class.
 *
 * @since  {DEPLOY_VERSION}
 */
#[AsCommand(
    name: 'create',
    description: 'Create a task file.',
)]
class CreateCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $dir = getcwd();

        $dest = new \SplFileInfo($dir . '/' . $name . '.php');

        if ($dest->isFile()) {
            throw new \RuntimeException(sprintf('File %s has exists.', $dest->getBasename()));
        }

        $template = file_get_contents(SB_ROOT . '/resources/templates/task_template.tpl');

        $template = TemplateHelper::parseVariable($template, ['task_name' => $name]);

        file_put_contents($dest->getPathname(), $template);

        $output->writeln('Written file at: ' . $dest->getPathname());

        return Command::SUCCESS;
    }
}
