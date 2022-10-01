<?php
/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SimpleBenchmark\Command;

use SimpleBenchmark\Benchmark;
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
    name: 'run',
    description: 'Run benchmark'
)]
class RunCommand extends Command
{
    protected function configure()
    {
        parent::configure();

        $this->addArgument('file', InputArgument::REQUIRED, 'The task file name.');
        $this->addArgument('loop', InputArgument::OPTIONAL, 'The loop times', 10000);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');

        $target = new \SplFileInfo($file);

        $benchmark = new Benchmark($target->getBasename('.php'));

        if (!is_file($target->getPathname())) {
            throw new \RuntimeException('No such file: ' . $target->getPathname());
        }

        include $target->getPathname();

        $times = (int) $input->getArgument('loop');

        $benchmark->execute($times);

        $output->writeln('');
        $output->writeln('<info>Benchmark Result</info>');
        $output->writeln('---------------------------------------------');
        $output->writeln('Run ' . number_format($times) . ' times');
        $output->writeln('');
        $output->writeln($benchmark->render());

        return Command::SUCCESS;
    }
}
