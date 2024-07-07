<?php

declare(strict_types=1);

namespace Corma\DBAL;

interface ServerVersionProvider
{
    /**
     * Returns the database server version
     */
    public function getServerVersion(): string;
}
