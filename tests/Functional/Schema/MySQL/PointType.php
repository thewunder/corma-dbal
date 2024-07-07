<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\MySQL;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Types\Type;

class PointType extends Type
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'POINT';
    }

    /**
     * {@inheritDoc}
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return ['point'];
    }
}
