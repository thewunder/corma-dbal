<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Types;

use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Type;
use Corma\DBAL\Types\Types;
use PHPUnit\Framework\Attributes\DataProvider;

use function rtrim;

final class DecimalTest extends FunctionalTestCase
{
    /** @return string[][] */
    public static function dataValuesProvider(): array
    {
        return [
            ['13.37'],
            ['13.0'],
        ];
    }

    #[DataProvider('dataValuesProvider')]
    public function testInsertAndRetrieveDecimal(string $expected): void
    {
        $table = new Table('decimal_table');
        $table->addColumn('val', Types::DECIMAL, ['precision' => 4, 'scale' => 2]);

        $this->dropAndCreateTable($table);

        $this->connection->insert(
            'decimal_table',
            ['val' => $expected],
            ['val' => Types::DECIMAL],
        );

        $value = Type::getType(Types::DECIMAL)->convertToPHPValue(
            $this->connection->fetchOne('SELECT val FROM decimal_table'),
            $this->connection->getDatabasePlatform(),
        );

        self::assertIsString($value);
        self::assertSame($this->stripTrailingZero($expected), $this->stripTrailingZero($value));
    }

    private function stripTrailingZero(string $expected): string
    {
        return rtrim(rtrim($expected, '0'), '.');
    }
}
