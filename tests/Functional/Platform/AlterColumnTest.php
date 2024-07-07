<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform;

use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Type;
use Corma\DBAL\Types\Types;

class AlterColumnTest extends FunctionalTestCase
{
    public function testColumnPositionRetainedAfterAltering(): void
    {
        $table = new Table('test_alter');
        $table->addColumn('c1', Types::INTEGER);
        $table->addColumn('c2', Types::INTEGER);

        $this->dropAndCreateTable($table);

        $table->getColumn('c1')
            ->setType(Type::getType(Types::STRING))
            ->setLength(16);

        $sm   = $this->connection->createSchemaManager();
        $diff = $sm->createComparator()
            ->compareTables($sm->introspectTable('test_alter'), $table);

        $sm->alterTable($diff);

        $table   = $sm->introspectTable('test_alter');
        $columns = $table->getColumns();

        self::assertCount(2, $columns);
        self::assertEqualsIgnoringCase('c1', $columns[0]->getName());
        self::assertEqualsIgnoringCase('c2', $columns[1]->getName());
    }
}
