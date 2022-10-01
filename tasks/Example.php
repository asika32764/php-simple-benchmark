<?php

/**
 * Part of simple-benchmark project.
 *
 * @copyright  Copyright (C) 2015 Lyra Soft. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

/** @var \SimpleBenchmark\Benchmark $benchmark */

$benchmark->addTask(
    'task1-md5',
    function () {
        md5(uniqid());
    }
);

$benchmark->addTask(
    'task2-sha1',
    function () {
        sha1(uniqid());
    }
);
