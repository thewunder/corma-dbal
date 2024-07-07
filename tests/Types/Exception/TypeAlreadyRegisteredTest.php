<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Types\Exception;

use Corma\DBAL\Types\Exception\TypeAlreadyRegistered;
use Corma\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class TypeAlreadyRegisteredTest extends TestCase
{
    public function testNew(): void
    {
        $exception = TypeAlreadyRegistered::new(Type::getType('string'));

        self::assertMatchesRegularExpression(
            '/Type of the class Doctrine\\\DBAL\\\Types\\\StringType@([0-9a-zA-Z]+) is already registered./',
            $exception->getMessage(),
        );
    }
}
