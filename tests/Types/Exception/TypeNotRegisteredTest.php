<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Types\Exception;

use Corma\DBAL\Types\Exception\TypeNotRegistered;
use Corma\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class TypeNotRegisteredTest extends TestCase
{
    public function testNew(): void
    {
        $exception = TypeNotRegistered::new(Type::getType('string'));

        self::assertMatchesRegularExpression(
            '/Type of the class Doctrine\\\DBAL\\\Types\\\StringType@([0-9a-zA-Z]+) is not registered./',
            $exception->getMessage(),
        );
    }
}
