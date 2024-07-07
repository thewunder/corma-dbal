<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Connection;

use Corma\DBAL\Cache\ArrayResult;
use Corma\DBAL\Cache\QueryCacheProfile;
use Corma\DBAL\Connection;
use Corma\DBAL\Driver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class CachedQueryTest extends TestCase
{
    public function testCachedQuery(): void
    {
        $cache = new ArrayAdapter();
        $data  = [['foo' => 'bar']];

        $connection = $this->createConnection(1, $data);
        $qcp        = new QueryCacheProfile(0, __FUNCTION__, $cache);

        self::assertSame($data, $connection->executeCacheQuery('SELECT 1', [], [], $qcp)->fetchAllAssociative());
        self::assertSame($data, $connection->executeCacheQuery('SELECT 1', [], [], $qcp)->fetchAllAssociative());

        self::assertCount(1, $cache->getItem(__FUNCTION__)->get());
    }

    public function testCachedQueryWithChangedImplementationIsExecutedTwice(): void
    {
        $data = [['baz' => 'qux']];

        $connection = $this->createConnection(2, $data);

        self::assertSame($data, $connection->executeCacheQuery(
            'SELECT 1',
            [],
            [],
            new QueryCacheProfile(0, __FUNCTION__, new ArrayAdapter()),
        )->fetchAllAssociative());

        self::assertSame($data, $connection->executeCacheQuery(
            'SELECT 1',
            [],
            [],
            new QueryCacheProfile(0, __FUNCTION__, new ArrayAdapter()),
        )->fetchAllAssociative());
    }

    /** @param list<array<string, mixed>> $data */
    private function createConnection(int $expectedQueryCount, array $data): Connection
    {
        $connection = $this->createMock(Driver\Connection::class);
        $connection->expects(self::exactly($expectedQueryCount))
            ->method('query')
            ->willReturnCallback(static fn(): ArrayResult => new ArrayResult($data));

        $driver = $this->createMock(Driver::class);
        $driver->method('connect')
            ->willReturn($connection);

        return new Connection([], $driver);
    }
}
