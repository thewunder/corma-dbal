<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional;

use Corma\DBAL\Exception;
use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Type;
use Corma\DBAL\Types\Types;
use Throwable;

class TemporaryTableTest extends FunctionalTestCase
{
    public function testDropTemporaryTableNotAutoCommitTransaction(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof OraclePlatform) {
            self::markTestSkipped('Test does not work on Oracle.');
        }

        $columnDefinitions = [
            [
                'name' => 'id',
                'type' => Type::getType(Types::INTEGER),
                'notnull' => true,
            ],
        ];

        $tempTable = $platform->getTemporaryTableName('my_temporary');

        $createTempTableSQL = $platform->getCreateTemporaryTableSnippetSQL() . ' ' . $tempTable . ' ('
                . $platform->getColumnDeclarationListSQL($columnDefinitions) . ')';
        $this->connection->executeStatement($createTempTableSQL);

        $table = new Table('nontemporary');
        $table->addColumn('id', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        $this->dropAndCreateTable($table);

        $this->connection->beginTransaction();
        $this->connection->insert('nontemporary', ['id' => 1]);
        $this->dropTemporaryTable('my_temporary');
        $this->connection->insert('nontemporary', ['id' => 2]);

        $this->connection->rollBack();

        // In an event of an error this result has one row, because of an implicit commit
        self::assertEquals([], $this->connection->fetchAllAssociative('SELECT * FROM nontemporary'));
    }

    public function testCreateTemporaryTableNotAutoCommitTransaction(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof OraclePlatform) {
            self::markTestSkipped('Test does not work on Oracle.');
        }

        $columnDefinitions = [
            [
                'name' => 'id',
                'type' => Type::getType(Types::INTEGER),
                'notnull' => true,
            ],
        ];

        $tempTable = $platform->getTemporaryTableName('my_temporary');

        $createTempTableSQL = $platform->getCreateTemporaryTableSnippetSQL() . ' ' . $tempTable . ' ('
                . $platform->getColumnDeclarationListSQL($columnDefinitions) . ')';

        $table = new Table('nontemporary');
        $table->addColumn('id', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        $this->dropAndCreateTable($table);

        $this->connection->beginTransaction();
        $this->connection->insert('nontemporary', ['id' => 1]);

        $this->dropTemporaryTable('my_temporary');
        $this->connection->executeStatement($createTempTableSQL);
        $this->connection->insert('nontemporary', ['id' => 2]);

        $this->connection->rollBack();

        try {
            $this->connection->executeStatement(
                $platform->getDropTemporaryTableSQL($tempTable),
            );
        } catch (Throwable) {
        }

        // In an event of an error this result has one row, because of an implicit commit
        self::assertEquals([], $this->connection->fetchAllAssociative('SELECT * FROM nontemporary'));
    }

    private function dropTemporaryTable(string $name): void
    {
        $platform = $this->connection->getDatabasePlatform();
        $sql      = $platform->getDropTemporaryTableSQL(
            $platform->getTemporaryTableName($name),
        );

        try {
            $this->connection->executeStatement($sql);
        } catch (Exception) {
        }
    }
}
