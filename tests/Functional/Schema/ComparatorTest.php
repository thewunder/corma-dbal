<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema;

use Corma\DBAL\Platforms\AbstractMySQLPlatform;
use Corma\DBAL\Platforms\MariaDBPlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;
use PHPUnit\Framework\Attributes\DataProvider;

class ComparatorTest extends FunctionalTestCase
{
    private AbstractSchemaManager $schemaManager;

    protected function setUp(): void
    {
        $this->schemaManager = $this->connection->createSchemaManager();
    }

    #[DataProvider('defaultValueProvider')]
    public function testDefaultValueComparison(string $type, mixed $value): void
    {
        $platform = $this->connection->getDatabasePlatform();
        if (
            $type === Types::TEXT && $platform instanceof AbstractMySQLPlatform
            && ! $platform instanceof MariaDBPlatform
        ) {
            // See https://dev.mysql.com/doc/relnotes/mysql/8.0/en/news-8-0-13.html#mysqld-8-0-13-data-types
            self::markTestSkipped('Oracle MySQL does not support default values on TEXT/BLOB columns until 8.0.13.');
        }

        $table = new Table('default_value');
        $table->addColumn('test', $type, ['default' => $value]);

        $this->dropAndCreateTable($table);

        $onlineTable = $this->schemaManager->introspectTable('default_value');

        self::assertTrue(
            $this->schemaManager->createComparator()
                ->compareTables($table, $onlineTable)
                ->isEmpty(),
        );
    }

    /** @return iterable<mixed[]> */
    public static function defaultValueProvider(): iterable
    {
        return [
            [Types::INTEGER, 1],
            [Types::BOOLEAN, false],
            [Types::TEXT, 'Doctrine'],
        ];
    }
}
