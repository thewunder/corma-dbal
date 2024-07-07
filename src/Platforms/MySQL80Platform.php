<?php

declare(strict_types=1);

namespace Corma\DBAL\Platforms;

use Corma\DBAL\Platforms\Keywords\KeywordList;
use Corma\DBAL\Platforms\Keywords\MySQL80Keywords;
use Corma\DBAL\SQL\Builder\SelectSQLBuilder;

/**
 * Provides the behavior, features and SQL dialect of the MySQL 8.0 database platform.
 */
class MySQL80Platform extends MySQLPlatform
{
    protected function createReservedKeywordsList(): KeywordList
    {
        return new MySQL80Keywords();
    }

    public function createSelectSQLBuilder(): SelectSQLBuilder
    {
        return AbstractPlatform::createSelectSQLBuilder();
    }
}
