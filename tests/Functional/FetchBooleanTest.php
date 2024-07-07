<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional;

use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Tests\FunctionalTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FetchBooleanTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        if ($this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform) {
            return;
        }

        self::markTestSkipped('Only PostgreSQL supports boolean values natively');
    }

    #[DataProvider('booleanLiteralProvider')]
    public function testBooleanConversionSqlLiteral(string $literal, bool $expected): void
    {
        self::assertSame([$expected], $this->connection->fetchNumeric(
            $this->connection->getDatabasePlatform()
                ->getDummySelectSQL($literal),
        ));
    }

    /** @return iterable<array{string, bool}> */
    public static function booleanLiteralProvider(): iterable
    {
        yield ['true', true];
        yield ['false', false];
    }
}
