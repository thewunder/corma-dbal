<?php

declare(strict_types=1);

namespace Corma\DBAL\Platforms;

use Corma\DBAL\SQL\Builder\SelectSQLBuilder;

/**
 * Provides the behavior, features and SQL dialect of the MariaDB 10.6 database platform.
 */
class MariaDB1060Platform extends MariaDB1052Platform
{
    public function createSelectSQLBuilder(): SelectSQLBuilder
    {
        return AbstractPlatform::createSelectSQLBuilder();
    }
}
