<?php

declare(strict_types=1);

namespace Corma\DBAL\Connection;

use Corma\DBAL\ServerVersionProvider;

class StaticServerVersionProvider implements ServerVersionProvider
{
    public function __construct(private readonly string $version)
    {
    }

    public function getServerVersion(): string
    {
        return $this->version;
    }
}
