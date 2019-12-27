# PHP Simple Benchmark CLI

## Installation via Composer

``` bash
composer global require asika/simple-benchmark
```

## Getting Started

Type `benchmark` or `sb` in terminal.

``` bash
sb
```

The output will be:

```
PHP Simple Benchmark Framework - version: 2.0.0-beta
------------------------------------------------------------

[sb Help]

Help of Simple Benchmark.

Usage:
  sb <command> [option]


Options:

  -h | --help       Display this help message.
  -q | --quiet      Do not output any message.
  -v | --verbose    Increase the verbosity of messages.
  --ansi            Set 'off' to suppress ANSI colors on unsupported terminals.

Commands:

  run       Run benchmark
  create    Create a task file.

Use `benchmark create TaskName` to generate a new task sample file to /tasks folder.

Use `benchmark run TaskFile.php [times]` to run benchmark
```

### Create a Task File

```bash
sb create TaskName
```

A file named `TaskName.php` will be generated to current folder.

Open `TaskName.php` you will see:

```php
<?php

/** @var \SimpleBenchmark\Benchmark $benchmark */

```

You can do your benchmark by `addTask()`.
 
```php
<?php

/** @var \SimpleBenchmark\Benchmark $benchmark */
$benchmark->addTask('task1-md5', function() {
    md5(uniqid());
});

$benchmark->addTask('task2-sha1', function() {
    sha1(uniqid());
});
```

### Run Benchmark

Run benchmark by this command:

``` bash
sb run TaskName.php
```

The output will be:

```
Benchmark Result
---------------------------------------------
Run 10,000 times

task1-md5:
  - Time: 0.0104s
  - Memory: 2048kb

task2-sha1:
  - Time: 0.0101s
  - Memory: 2048kb

```

You can set times (Default is 10000) at second argument:

``` bash
php benchmark run TaskName.php 15000
```
