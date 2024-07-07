<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema;

use Corma\DBAL\Connection;
use Corma\DBAL\Exception;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\Comparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Schema\TableDiff;
use PHPUnit\Framework\TestCase;

final class ComparatorTestUtils
{
    /** @throws Exception */
    public static function diffFromActualToDesiredTable(
        AbstractSchemaManager $schemaManager,
        Comparator $comparator,
        Table $desiredTable,
    ): TableDiff {
        return $comparator->compareTables(
            $schemaManager->introspectTable($desiredTable->getName()),
            $desiredTable,
        );
    }

    /** @throws Exception */
    public static function diffFromDesiredToActualTable(
        AbstractSchemaManager $schemaManager,
        Comparator $comparator,
        Table $desiredTable,
    ): TableDiff {
        return $comparator->compareTables(
            $desiredTable,
            $schemaManager->introspectTable($desiredTable->getName()),
        );
    }

    public static function assertDiffNotEmpty(Connection $connection, Comparator $comparator, Table $table): void
    {
        $schemaManager = $connection->createSchemaManager();

        $diff = self::diffFromActualToDesiredTable($schemaManager, $comparator, $table);

        TestCase::assertFalse($diff->isEmpty());

        $schemaManager->alterTable($diff);

        TestCase::assertTrue(
            self::diffFromActualToDesiredTable($schemaManager, $comparator, $table)
                ->isEmpty(),
        );
        TestCase::assertTrue(
            self::diffFromDesiredToActualTable($schemaManager, $comparator, $table)
                ->isEmpty(),
        );
    }
}
