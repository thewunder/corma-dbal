<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Portability;

use Corma\DBAL\Driver\Result as DriverResult;
use Corma\DBAL\Portability\Converter;
use Corma\DBAL\Portability\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    #[DataProvider('fetchProvider')]
    public function testFetch(string $source, callable $fetch, mixed $return): void
    {
        $driverResult = $this->createMock(DriverResult::class);
        $driverResult->expects(self::once())
            ->method($source)
            ->willReturn($return);

        $result = $this->newResult($driverResult);

        self::assertSame($return, $fetch($result));
    }

    /** @return iterable<string,array<int,mixed>> */
    public static function fetchProvider(): iterable
    {
        yield 'numeric' => [
            'fetchNumeric',
            static fn(Result $result) => $result->fetchNumeric(),
            ['bar'],
        ];

        yield 'associative' => [
            'fetchAssociative',
            static fn(Result $result) => $result->fetchAssociative(),
            ['foo' => 'bar'],
        ];

        yield 'one' => [
            'fetchOne',
            static fn(Result $result): mixed => $result->fetchOne(),
            'bar',
        ];

        yield 'all-numeric' => [
            'fetchAllNumeric',
            static fn(Result $result): array => $result->fetchAllNumeric(),
            [
                ['bar'],
                ['baz'],
            ],
        ];

        yield 'all-associative' => [
            'fetchAllAssociative',
            static fn(Result $result): array => $result->fetchAllAssociative(),
            [
                ['foo' => 'bar'],
                ['foo' => 'baz'],
            ],
        ];

        yield 'first-column' => [
            'fetchFirstColumn',
            static fn(Result $result): array => $result->fetchFirstColumn(),
            [
                'bar',
                'baz',
            ],
        ];
    }

    public function testRowCount(): void
    {
        $driverResult = $this->createMock(DriverResult::class);
        $driverResult->expects(self::once())
            ->method('rowCount')
            ->willReturn(666);

        $result = $this->newResult($driverResult);

        self::assertSame(666, $result->rowCount());
    }

    public function testColumnCount(): void
    {
        $driverResult = $this->createMock(DriverResult::class);
        $driverResult->expects(self::once())
            ->method('columnCount')
            ->willReturn(666);

        $result = $this->newResult($driverResult);

        self::assertSame(666, $result->columnCount());
    }

    public function testFree(): void
    {
        $driverResult = $this->createMock(DriverResult::class);
        $driverResult->expects(self::once())
            ->method('free');

        $this->newResult($driverResult)->free();
    }

    private function newResult(DriverResult $driverResult): Result
    {
        return new Result(
            $driverResult,
            new Converter(false, false, null),
        );
    }
}
