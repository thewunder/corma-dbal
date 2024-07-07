<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\Types;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Types\Exception\InvalidFormat;
use Corma\DBAL\Types\Exception\InvalidType;
use Corma\DBAL\Types\Type;
use InvalidArgumentException;

use function is_string;

class MoneyType extends Type
{
    public const NAME = 'money';

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Money) {
            return (string) $value;
        }

        throw InvalidType::new($value, self::NAME, ['null', Money::class]);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Money
    {
        if ($value === null || $value instanceof Money) {
            return $value;
        }

        if (! is_string($value)) {
            throw InvalidType::new($value, self::NAME, ['null', 'string']);
        }

        try {
            return new Money($value);
        } catch (InvalidArgumentException $e) {
            throw InvalidFormat::new($value, self::NAME, Money::class, $e);
        }
    }
}
