<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Platforms\SQLServer;

use Corma\DBAL\Platforms\SQLServer\Comparator;
use Corma\DBAL\Platforms\SQLServerPlatform;
use Corma\DBAL\Tests\Schema\AbstractComparatorTestCase;

class ComparatorTest extends AbstractComparatorTestCase
{
    protected function setUp(): void
    {
        $this->comparator = new Comparator(new SQLServerPlatform(), '');
    }
}
