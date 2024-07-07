<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/static-analysis',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withSets([PHPUnitSetList::PHPUNIT_100])
    ->withDeadCodeLevel(22);
