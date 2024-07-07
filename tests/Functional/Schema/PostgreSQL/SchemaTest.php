<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\PostgreSQL;

use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Schema\Column;
use Corma\DBAL\Schema\Schema;
use Corma\DBAL\Schema\Sequence;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\IntegerType;

final class SchemaTest extends FunctionalTestCase
{
    public function testCreateTableWithSequenceInColumnDefinition(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if (! $platform instanceof PostgreSQLPlatform) {
            self::markTestSkipped('Test is for PostgreSQL.');
        }

        $this->dropTableIfExists('my_table');

        $options  = ['default' => 'nextval(\'my_table_id_seq\'::regclass)'];
        $table    = new Table('my_table', [new Column('id', new IntegerType(), $options)]);
        $sequence = new Sequence('my_table_id_seq');

        $schema = new Schema([$table], [$sequence]);
        foreach ($schema->toSql($platform) as $sql) {
            $this->connection->executeStatement($sql);
        }

        $result = $this->connection->fetchAssociative(
            'SELECT column_default FROM information_schema.columns WHERE table_name = ?',
            ['my_table'],
        );

        self::assertNotFalse($result);
        self::assertEquals('nextval(\'my_table_id_seq\'::regclass)', $result['column_default']);
    }
}
