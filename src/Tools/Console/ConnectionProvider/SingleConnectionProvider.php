<?php

declare(strict_types=1);

namespace Corma\DBAL\Tools\Console\ConnectionProvider;

use Corma\DBAL\Connection;
use Corma\DBAL\Tools\Console\ConnectionNotFound;
use Corma\DBAL\Tools\Console\ConnectionProvider;

use function sprintf;

class SingleConnectionProvider implements ConnectionProvider
{
    public function __construct(
        private readonly Connection $connection,
        private readonly string $defaultConnectionName = 'default',
    ) {
    }

    public function getDefaultConnection(): Connection
    {
        return $this->connection;
    }

    public function getConnection(string $name): Connection
    {
        if ($name !== $this->defaultConnectionName) {
            throw new ConnectionNotFound(sprintf('Connection with name "%s" does not exist.', $name));
        }

        return $this->connection;
    }
}
