<?php

declare(strict_types=1);

namespace Corma\DBAL\Cache\Exception;

use Corma\DBAL\Cache\CacheException;

/** @psalm-immutable */
final class NoResultDriverConfigured extends CacheException
{
    public static function new(): self
    {
        return new self('Trying to cache a query but no result driver is configured.');
    }
}
