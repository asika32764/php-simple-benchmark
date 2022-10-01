<?php

/**
 * Part of php-simple-benchmark project.
 *
 * @copyright  Copyright (C) 2019 .
 * @license    __LICENSE__
 */

namespace SimpleBenchmark;

use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * The Benchmark class.
 *
 * @since  __DEPLOY_VERSION__
 */
class Benchmark
{
    public const SECOND = 1;

    public const MILLI_SECOND = 1000;

    public const MICRO_SECOND = 1000000;

    public const SORT_ASC = 'asc';

    public const SORT_DESC = 'desc';

    /**
     * Property profiler.
     *
     * @var  Stopwatch|null
     */
    protected ?Stopwatch $stopwatch = null;

    /**
     * Property name.
     *
     * @var  string
     */
    protected string $name;

    /**
     * Property times.
     *
     * @var  int
     */
    protected int $times = 100;

    /**
     * Property tasks.
     *
     * @var  array
     */
    protected array $tasks = [];

    /**
     * Property results.
     *
     * @var  array
     */
    protected array $results = [];

    /**
     * Property timeFormat.
     *
     * @var integer
     */
    protected int $format = 1;

    /**
     * Property renderHandler.
     *
     * @var \Closure
     */
    protected ?\Closure $renderOneHandler = null;

    /**
     * Class init.
     *
     * @param  string|null     $name
     * @param  Stopwatch|null  $stopwatch
     * @param  int             $times
     */
    public function __construct(?string $name = null, Stopwatch $stopwatch = null, int $times = 100)
    {
        $name = $name ?: 'benchmark-' . uniqid();

        $this->stopwatch = $stopwatch ?: new Stopwatch(true);
        $this->name = $name;
        $this->times = $times;
    }

    /**
     * setTimeFormat
     *
     * @param  int  $format
     *
     * @return  static
     */
    public function setTimeFormat(int $format = self::SECOND): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * addTask
     *
     * @param  string    $name
     * @param  callable  $callback
     *
     * @return  static
     * @throws \InvalidArgumentException
     */
    public function addTask(string $name, callable $callback): static
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Task should be a callback.');
        }

        $this->tasks[$name] = $callback;

        return $this;
    }

    /**
     * run
     *
     * @param  integer  $times
     *
     * @return  $this
     */
    public function execute(int $times = null): static
    {
        $times = $times ?: $this->times;

        foreach ($this->tasks as $name => $task) {
            $this->run($name, $task, $times);
        }

        return $this;
    }

    /**
     * runTask
     *
     * @param  string    $name
     * @param  callable  $callback
     * @param  integer   $times
     *
     * @return  $this
     */
    protected function run(string $name, callable $callback, int $times): static
    {
        $this->stopwatch->start($name);

        for ($i = 0; $i < $times; $i++) {
            $callback();
        }

        $event = $this->stopwatch->stop($name);

        $this->results[$name] = $event;

        return $this;
    }

    /**
     * Method to get property Results
     *
     * @param ?string  $sort  Null, desc or asc.
     *
     * @return  StopwatchEvent[]
     */
    public function getResults(?string $sort = null): array
    {
        $results = $this->results;

        if ($sort) {
            (strtolower($sort) === static::SORT_DESC)
                ? arsort($results)
                : asort($results);
        }

        return $results;
    }

    /**
     * Method to get property Results
     *
     * @param  string  $name
     *
     * @return  StopwatchEvent
     */
    public function getResult(string $name): StopwatchEvent
    {
        return $this->results[$name];
    }

    /**
     * renderResult
     *
     * @param  string  $name
     * @param  bool    $round
     *
     * @return  string
     */
    public function renderOne(string $name, bool $round = false): string
    {
        $result = $this->getResult($name);

        if ($this->renderOneHandler) {
            $closure = $this->renderOneHandler;

            return $closure($name, $result, $round, $this->format);
        }

        // if ($round !== false) {
        //     $result = round($result, $round);
        // }
        //
        // switch ($this->format) {
        //     case static::MILLI_SECOND:
        //         $unit = 'ms';
        //         break;
        //
        //     case static::MICRO_SECOND:
        //         $unit = 'μs';
        //         break;
        //
        //     case static::SECOND:
        //     default:
        //         $unit = 's';
        //         break;
        // }

        $time = $result->getDuration();
        $memory = $result->getMemory() / 1024;

        return <<<EOL
{$name}:
  - Time: {$time}ms
  - Memory: {$memory}kb

EOL;
    }

    /**
     * renderResult
     *
     * @param  bool     $round
     * @param  ?string  $sort
     * @param  bool     $html
     *
     * @return  string
     */
    public function render(bool $round = false, ?string $sort = null, bool $html = false): string
    {
        $output = [];

        foreach ($this->getResults($sort) as $name => $result) {
            $output[] = $this->renderOne($name, $round);
        }

        $separator = $html ? "<br />\n" : "\n";

        return implode($separator, $output);
    }

    /**
     * Method to get property Times
     *
     * @return  int
     */
    public function getTimes(): int
    {
        return $this->times;
    }

    /**
     * Method to set property times
     *
     * @param  int  $times
     *
     * @return  static  Return self to support chaining.
     */
    public function setTimes(int $times): static
    {
        $this->times = $times;

        return $this;
    }

    /**
     * Method to get property RenderHandler
     *
     * @return  \Closure|null
     */
    public function getRenderOneHandler(): ?\Closure
    {
        return $this->renderOneHandler;
    }

    /**
     * Method to set property renderHandler
     *
     * @param  \Closure|null  $renderOneHandler
     *
     * @return  static  Return self to support chaining.
     */
    public function setRenderOneHandler(?\Closure $renderOneHandler): static
    {
        $this->renderOneHandler = $renderOneHandler;

        return $this;
    }
}
