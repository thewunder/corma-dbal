<?php

declare(strict_types=1);

namespace Corma\DBAL\Types;

use Corma\DBAL\ParameterType;
use Corma\DBAL\Platforms\AbstractPlatform;

final class AsciiStringType extends StringType
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getAsciiStringTypeDeclarationSQL($column);
    }

    public function getBindingType(): ParameterType
    {
        return ParameterType::ASCII;
    }
}
