<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform;

use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

use function str_repeat;

/**
 * This class holds tests that make sure generated SQL statements respect to platform restrictions
 * like maximum element name length
 */
class PlatformRestrictionsTest extends FunctionalTestCase
{
    /**
     * Tests element names that are at the boundary of the identifier length limit.
     * Ensures generated auto-increment identifier name respects to platform restrictions.
     */
    public function testMaxIdentifierLengthLimitWithAutoIncrement(): void
    {
        $platform   = $this->connection->getDatabasePlatform();
        $tableName  = str_repeat('x', $platform->getMaxIdentifierLength());
        $columnName = str_repeat('y', $platform->getMaxIdentifierLength());
        $table      = new Table($tableName);
        $table->addColumn($columnName, Types::INTEGER, ['autoincrement' => true]);
        $table->setPrimaryKey([$columnName]);
        $this->dropAndCreateTable($table);
        $createdTable = $this->connection->createSchemaManager()->introspectTable($tableName);

        self::assertTrue($createdTable->hasColumn($columnName));
        self::assertNotNull($createdTable->getPrimaryKey());
    }
}
