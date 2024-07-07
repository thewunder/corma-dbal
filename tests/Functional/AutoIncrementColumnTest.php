<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional;

use Corma\DBAL\Platforms\SQLServerPlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

class AutoIncrementColumnTest extends FunctionalTestCase
{
    private bool $shouldDisableIdentityInsert = false;

    protected function setUp(): void
    {
        $table = new Table('auto_increment_table');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $table->setPrimaryKey(['id']);

        $this->dropAndCreateTable($table);
    }

    protected function tearDown(): void
    {
        if (! $this->shouldDisableIdentityInsert) {
            return;
        }

        $this->connection->executeStatement('SET IDENTITY_INSERT auto_increment_table OFF');
    }

    public function testInsertIdentityValue(): void
    {
        if ($this->connection->getDatabasePlatform() instanceof SQLServerPlatform) {
            $this->connection->executeStatement('SET IDENTITY_INSERT auto_increment_table ON');
            $this->shouldDisableIdentityInsert = true;
        }

        $this->connection->insert('auto_increment_table', ['id' => 2]);
        self::assertEquals(2, $this->connection->fetchOne('SELECT id FROM auto_increment_table'));
    }
}
