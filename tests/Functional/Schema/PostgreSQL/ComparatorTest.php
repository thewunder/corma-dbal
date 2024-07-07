<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\PostgreSQL;

use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\Column;
use Corma\DBAL\Schema\Comparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\Functional\Schema\ComparatorTestUtils;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Type;
use Corma\DBAL\Types\Types;

final class ComparatorTest extends FunctionalTestCase
{
    private AbstractSchemaManager $schemaManager;

    private Comparator $comparator;

    protected function setUp(): void
    {
        if (! $this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform) {
            self::markTestSkipped('This test covers PostgreSQL-specific schema comparison scenarios.');
        }

        $this->schemaManager = $this->connection->createSchemaManager();
        $this->comparator    = $this->schemaManager->createComparator();
    }

    /**
     * The PostgreSQL platform maps both BLOB and BINARY columns to the BYTEA column type.
     *
     * @see PostgreSQLPlatform::getBlobTypeDeclarationSQL()
     */
    public function testCompareBinaryAndBlob(): void
    {
        $this->testColumnModification(static fn(Table $table, string $name): Column => $table->addColumn($name, Types::BINARY), static function (Column $column): void {
            $column->setType(Type::getType(Types::BLOB));
        });
    }

    /**
     * The PostgreSQL platform maps both BINARY and VARBINARY columns to the BYTEA column type.
     *
     * @see PostgreSQLPlatform::getVarbinaryTypeDeclarationSQLSnippet()
     */
    public function testCompareBinaryAndVarbinary(): void
    {
        $this->testColumnModification(static fn(Table $table, string $name): Column => $table->addColumn($name, Types::BINARY), static function (Column $column): void {
            $column->setFixed(true);
        });
    }

    /**
     * The PostgreSQL platform disregards the "length" attribute of BINARY and VARBINARY columns.
     *
     * @see PostgreSQLPlatform::getBinaryTypeDeclarationSQLSnippet()
     */
    public function testCompareBinariesOfDifferentLength(): void
    {
        $this->testColumnModification(static fn(Table $table, string $name): Column => $table->addColumn($name, Types::BINARY, ['length' => 16]), static function (Column $column): void {
            $column->setLength(32);
        });
    }

    private function testColumnModification(callable $addColumn, callable $modifyColumn): void
    {
        $table  = new Table('comparator_test');
        $column = $addColumn($table, 'id');
        $this->dropAndCreateTable($table);

        $modifyColumn($column);

        self::assertTrue(ComparatorTestUtils::diffFromActualToDesiredTable(
            $this->schemaManager,
            $this->comparator,
            $table,
        )->isEmpty());

        self::assertTrue(ComparatorTestUtils::diffFromDesiredToActualTable(
            $this->schemaManager,
            $this->comparator,
            $table,
        )->isEmpty());
    }
}
