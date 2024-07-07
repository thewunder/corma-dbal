<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Ticket;

use Corma\DBAL\Connection;
use Corma\DBAL\Platforms\SQLServerPlatform;
use Corma\DBAL\Schema\SQLServerSchemaManager;
use Corma\DBAL\Types\DecimalType;
use Corma\DBAL\Types\Types;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class DBAL461Test extends TestCase
{
    public function testIssue(): void
    {
        $conn     = $this->createMock(Connection::class);
        $platform = new SQLServerPlatform();
        $platform->registerDoctrineTypeMapping('numeric', Types::DECIMAL);

        $schemaManager = new SQLServerSchemaManager($conn, $platform);

        $reflectionMethod = new ReflectionMethod($schemaManager, '_getPortableTableColumnDefinition');
        $column           = $reflectionMethod->invoke($schemaManager, [
            'type' => 'numeric(18,0)',
            'length' => null,
            'default' => null,
            'notnull' => false,
            'scale' => 18,
            'precision' => 0,
            'autoincrement' => false,
            'collation' => 'foo',
        ]);

        self::assertInstanceOf(DecimalType::class, $column->getType());
    }
}
