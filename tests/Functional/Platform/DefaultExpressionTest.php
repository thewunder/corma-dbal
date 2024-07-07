<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform;

use Corma\DBAL\Platforms\AbstractMySQLPlatform;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

use function sprintf;

class DefaultExpressionTest extends FunctionalTestCase
{
    public function testCurrentDate(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof AbstractMySQLPlatform) {
            self::markTestSkipped('Not supported on MySQL');
        }

        $this->assertDefaultExpression(Types::DATE_MUTABLE, static fn(AbstractPlatform $platform): string => $platform->getCurrentDateSQL());
    }

    public function testCurrentTime(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof AbstractMySQLPlatform) {
            self::markTestSkipped('Not supported on MySQL');
        }

        if ($platform instanceof OraclePlatform) {
            self::markTestSkipped('Not supported on Oracle');
        }

        $this->assertDefaultExpression(Types::TIME_MUTABLE, static fn(AbstractPlatform $platform): string => $platform->getCurrentTimeSQL());
    }

    public function testCurrentTimestamp(): void
    {
        $this->assertDefaultExpression(Types::DATETIME_MUTABLE, static fn(AbstractPlatform $platform): string => $platform->getCurrentTimestampSQL());
    }

    private function assertDefaultExpression(string $type, callable $expression): void
    {
        $platform   = $this->connection->getDatabasePlatform();
        $defaultSql = $expression($platform, $this);

        $table = new Table('default_expr_test');
        $table->addColumn('actual_value', $type);
        $table->addColumn('default_value', $type, ['default' => $defaultSql]);
        $this->dropAndCreateTable($table);

        $this->connection->executeStatement(
            sprintf(
                'INSERT INTO default_expr_test (actual_value) VALUES (%s)',
                $defaultSql,
            ),
        );

        $row = $this->connection->fetchNumeric('SELECT default_value, actual_value FROM default_expr_test');
        self::assertNotFalse($row);

        self::assertEquals(...$row);
    }
}
