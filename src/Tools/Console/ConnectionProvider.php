<?php

declare(strict_types=1);

namespace Corma\DBAL\Tools\Console;

use Corma\DBAL\Connection;

interface ConnectionProvider
{
    public function getDefaultConnection(): Connection;

    /** @throws ConnectionNotFound in case a connection with the given name does not exist. */
    public function getConnection(string $name): Connection;
}
