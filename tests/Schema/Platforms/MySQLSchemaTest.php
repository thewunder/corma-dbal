<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Schema\Platforms;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\MySQL;
use Corma\DBAL\Platforms\MySQL\CharsetMetadataProvider;
use Corma\DBAL\Platforms\MySQL\CollationMetadataProvider;
use Corma\DBAL\Platforms\MySQL\DefaultTableOptions;
use Corma\DBAL\Platforms\MySQLPlatform;
use Corma\DBAL\Schema\Comparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Types\Types;
use PHPUnit\Framework\TestCase;

class MySQLSchemaTest extends TestCase
{
    private AbstractPlatform $platform;

    protected function setUp(): void
    {
        $this->platform = new MySQLPlatform();
    }

    public function testGenerateForeignKeySQL(): void
    {
        $tableOld = new Table('test');
        $tableOld->addColumn('foo_id', Types::INTEGER);
        $tableOld->addForeignKeyConstraint('test_foreign', ['foo_id'], ['foo_id']);

        $sqls = [];
        foreach ($tableOld->getForeignKeys() as $fk) {
            $sqls[] = $this->platform->getCreateForeignKeySQL($fk, $tableOld->getQuotedName($this->platform));
        }

        self::assertEquals(
            [
                'ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C8E48560F FOREIGN KEY (foo_id)'
                    . ' REFERENCES test_foreign (foo_id)',
            ],
            $sqls,
        );
    }

    public function testClobNoAlterTable(): void
    {
        $tableOld = new Table('test');
        $tableOld->addColumn('id', Types::INTEGER);
        $tableOld->addColumn('description', Types::STRING, ['length' => 65536]);
        $tableNew = clone $tableOld;

        $tableNew->setPrimaryKey(['id']);

        $diff = $this->createComparator()
            ->compareTables($tableOld, $tableNew);

        $sql = $this->platform->getAlterTableSQL($diff);

        self::assertEquals(
            ['ALTER TABLE test ADD PRIMARY KEY (id)'],
            $sql,
        );
    }

    private function createComparator(): Comparator
    {
        return new MySQL\Comparator(
            new MySQLPlatform(),
            self::createStub(CharsetMetadataProvider::class),
            self::createStub(CollationMetadataProvider::class),
            new DefaultTableOptions('utf8mb4', 'utf8mb4_general_ci'),
        );
    }
}
