<?php

declare(strict_types=1);

namespace Corma\DBAL\Portability;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\DB2Platform;
use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Platforms\SQLServerPlatform;

final class OptimizeFlags
{
    /**
     * Platform-specific portability flags that need to be excluded from the user-provided mode
     * since the platform already operates in this mode to avoid unnecessary conversion overhead.
     *
     * @var array<class-string, int>
     */
    private static array $platforms = [
        DB2Platform::class        => 0,
        OraclePlatform::class     => Connection::PORTABILITY_EMPTY_TO_NULL,
        PostgreSQLPlatform::class => 0,
        SQLitePlatform::class     => 0,
        SQLServerPlatform::class  => 0,
    ];

    public function __invoke(AbstractPlatform $platform, int $flags): int
    {
        foreach (self::$platforms as $class => $mask) {
            if ($platform instanceof $class) {
                $flags &= ~$mask;

                break;
            }
        }

        return $flags;
    }
}
