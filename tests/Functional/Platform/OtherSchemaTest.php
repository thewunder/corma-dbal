<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform;

use Corma\DBAL\DriverManager;
use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Tools\DsnParser;
use Corma\DBAL\Types\Types;

class OtherSchemaTest extends FunctionalTestCase
{
    public function testATableCanBeCreatedInAnotherSchema(): void
    {
        $databasePlatform = $this->connection->getDatabasePlatform();
        if (! ($databasePlatform instanceof SQLitePlatform)) {
            self::markTestSkipped('This test requires SQLite');
        }

        $this->connection->executeStatement("ATTACH DATABASE '/tmp/test_other_schema.sqlite' AS other");

        $table = new Table('other.test_other_schema');
        $table->addColumn('id', Types::INTEGER);
        $table->addIndex(['id']);

        $this->dropAndCreateTable($table);
        $this->connection->insert('other.test_other_schema', ['id' => 1]);

        self::assertEquals(1, $this->connection->fetchOne('SELECT COUNT(*) FROM other.test_other_schema'));
        $dsnParser   = new DsnParser();
        $connection  = DriverManager::getConnection(
            $dsnParser->parse('sqlite3:////tmp/test_other_schema.sqlite'),
        );
        $onlineTable = $connection->createSchemaManager()->introspectTable('test_other_schema');
        self::assertCount(1, $onlineTable->getIndexes());
    }
}
