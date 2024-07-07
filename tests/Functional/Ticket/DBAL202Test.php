<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Ticket;

use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

class DBAL202Test extends FunctionalTestCase
{
    protected function setUp(): void
    {
        if (! $this->connection->getDatabasePlatform() instanceof OraclePlatform) {
            self::markTestSkipped('Oracle only test');
        }

        if ($this->connection->createSchemaManager()->tableExists('DBAL202')) {
            $this->connection->executeStatement('DELETE FROM DBAL202');
        } else {
            $table = new Table('DBAL202');
            $table->addColumn('id', Types::INTEGER);
            $table->setPrimaryKey(['id']);

            $this->connection->createSchemaManager()->createTable($table);
        }
    }

    public function testStatementRollback(): void
    {
        $stmt = $this->connection->prepare('INSERT INTO DBAL202 VALUES (8)');
        $this->connection->beginTransaction();
        $stmt->executeStatement();
        $this->connection->rollBack();

        self::assertEquals(0, $this->connection->fetchOne('SELECT COUNT(1) FROM DBAL202'));
    }

    public function testStatementCommit(): void
    {
        $stmt = $this->connection->prepare('INSERT INTO DBAL202 VALUES (8)');
        $this->connection->beginTransaction();
        $stmt->executeStatement();
        $this->connection->commit();

        self::assertEquals(1, $this->connection->fetchOne('SELECT COUNT(1) FROM DBAL202'));
    }
}
