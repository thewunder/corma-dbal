<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\Middleware;

use Corma\DBAL\Driver\Middleware\AbstractStatementMiddleware;
use Corma\DBAL\Driver\Result;
use Corma\DBAL\Driver\Statement;
use PHPUnit\Framework\TestCase;

final class AbstractStatementMiddlewareTest extends TestCase
{
    public function testExecute(): void
    {
        $result    = $this->createMock(Result::class);
        $statement = $this->createMock(Statement::class);
        $statement->expects(self::once())
            ->method('execute')
            ->willReturn($result);

        self::assertSame($result, $this->createMiddleware($statement)->execute());
    }

    private function createMiddleware(Statement $statement): AbstractStatementMiddleware
    {
        return new class ($statement) extends AbstractStatementMiddleware {
        };
    }
}
