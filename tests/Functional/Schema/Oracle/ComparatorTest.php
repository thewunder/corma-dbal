<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\Oracle;

use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\Comparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\Functional\Schema\ComparatorTestUtils;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

final class ComparatorTest extends FunctionalTestCase
{
    private AbstractSchemaManager $schemaManager;

    private Comparator $comparator;

    protected function setUp(): void
    {
        if (! $this->connection->getDatabasePlatform() instanceof OraclePlatform) {
            self::markTestSkipped('This test covers Oracle-specific schema comparison scenarios.');
        }

        $this->schemaManager = $this->connection->createSchemaManager();
        $this->comparator    = $this->schemaManager->createComparator();
    }

    /**
     * Oracle does not support fixed length binary columns. The DBAL will map the {@see Types::BINARY} type
     * to the variable-length RAW column type regardless of the "fixed" attribute.
     *
     * There should not be a diff when comparing a variable-length and a fixed-length column
     * that are otherwise the same.
     *
     * @see OraclePlatform::getBinaryTypeDeclarationSQLSnippet()
     */
    public function testChangeBinaryColumnFixed(): void
    {
        $table  = new Table('comparator_test');
        $column = $table->addColumn('id', Types::BINARY, [
            'length' => 32,
            'fixed' => true,
        ]);
        $this->dropAndCreateTable($table);

        $column->setFixed(false);

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
