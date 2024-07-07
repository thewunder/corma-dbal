<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Ticket;

use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

class DBAL510Test extends FunctionalTestCase
{
    protected function setUp(): void
    {
        if ($this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform) {
            return;
        }

        self::markTestSkipped('PostgreSQL only test');
    }

    public function testSearchPathSchemaChanges(): void
    {
        $table = new Table('dbal510tbl');
        $table->addColumn('id', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        $this->dropAndCreateTable($table);

        $schemaManager = $this->connection->createSchemaManager();
        $onlineTable   = $schemaManager->introspectTable('dbal510tbl');

        self::assertTrue(
            $schemaManager->createComparator()
                ->compareTables($onlineTable, $table)
                ->isEmpty(),
        );
    }
}
