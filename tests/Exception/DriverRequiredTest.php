<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Exception;

use Corma\DBAL\Exception\DriverRequired;
use PHPUnit\Framework\TestCase;

use function sprintf;

class DriverRequiredTest extends TestCase
{
    public function testDriverRequiredWithUrl(): void
    {
        $url       = 'mysql://localhost';
        $exception = DriverRequired::new($url);

        self::assertSame(
            sprintf(
                'The options "driver" or "driverClass" are mandatory if a connection URL without scheme ' .
                'is given to DriverManager::getConnection(). Given URL "%s".',
                $url,
            ),
            $exception->getMessage(),
        );
    }
}
