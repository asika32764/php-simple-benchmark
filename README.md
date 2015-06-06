# PHP Simple Benchmark framework

## Installation via Composer

``` bash
php composer.phar create-project asika/simple-benchmark simple-benchmark 1.*

cd simple-benchmark
```

Or download a pre-compiled package [here](https://github.com/asika32764/php-simple-benchmark/releases/download/1.0.0/simple-benchmark.zip)

## Getting Started

See usage by this command:

``` bash
php benchmark
```

The output will be:

```
PHP Simple Benchmark Framework - version: 1.0
------------------------------------------------------------

[benchmark Help]

Help of Simple Benchmark.

Usage:
  benchmark <command> [option]


Options:

  -h | --help       Display this help message.
  -q | --quiet      Do not output any message.
  -v | --verbose    Increase the verbosity of messages.
  --ansi            Set 'off' to suppress ANSI colors on unsupported terminals.

Commands:

  run       Run benchmark
  list      List task files.
  create    Create a task file.

Use `benchmark list` to list all tasks.

Use `benchmark create TaskName` to generate a new task sample file to /tasks folder.

Use `benchmark run TaskName [times]` to run benchmark
```

### Create A Task File

``` bash
php benchmark create TaskName
```

A class named `TaskName` will be generated to `/tasks` folder.

Open `/tasks/TaskName.php` you will see:

``` php
<?php
/**
 * Part of simple-benchmark project. 
 *
 * @copyright  Copyright (C) 2015 Lyra Soft. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

/**
 * The TaskName task.
 */
class TaskName extends \SimpleBenchmark\Task\AbstractTask
{
	/**
	 * Run your benchmark here.
	 *
	 * @param   \Windwalker\Profiler\Benchmark  $benchmark
	 *
	 * @return  void
	 */
	protected function doExecute(\Windwalker\Profiler\Benchmark $benchmark)
	{
		// Do your benchmark here.
	}
}
```

You can do your benchmark in `doExecute()` method.
 
``` php
protected function doExecute(\Windwalker\Profiler\Benchmark $benchmark)
{
    $benchmark->addTask('task1-md5', function() {
        md5(uniqid());
    });
    
    $benchmark->addTask('task2-sha1', function() {
        sha1(uniqid());
    });
}
```

More detail please see: [Windwalker Benchmark package](https://github.com/ventoviro/windwalker-profiler)

### List Tasks

``` bash
php benchmark list
```

Your will get this output:

```
Available files:
-----------------------------------------
Example.php
TaskName.php
```

### Run Benchmark

Run banchmark by this command:

``` bash
php benchmark run TaskName
```

The output will be:

```
Benchmark Result
---------------------------------------------
task1-md5 => 0.31799101829529 s
task2-sha1 => 0.31735110282898 s
```

You can set times (Default is 10000) at second argument:

``` bash
php benchmark run TaskName 15000
```

## Todo

Add memory support in profiler.

