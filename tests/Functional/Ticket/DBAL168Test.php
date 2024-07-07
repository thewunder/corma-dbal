<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Ticket;

use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

class DBAL168Test extends FunctionalTestCase
{
    public function testDomainsTable(): void
    {
        $table = new Table('domains');
        $table->addColumn('id', Types::INTEGER);
        $table->addColumn('parent_id', Types::INTEGER);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('domains', ['parent_id'], ['id']);

        $this->connection->createSchemaManager()->createTable($table);
        $table = $this->connection->createSchemaManager()->introspectTable('domains');

        self::assertEquals('domains', $table->getName());
    }
}
