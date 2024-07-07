<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\AbstractSQLiteDriver\Middleware;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\Connection;
use Corma\DBAL\Driver\Middleware;
use Corma\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use SensitiveParameter;

final class EnableForeignKeys implements Middleware
{
    public function wrap(Driver $driver): Driver
    {
        return new class ($driver) extends AbstractDriverMiddleware {
            /**
             * {@inheritDoc}
             */
            public function connect(
                #[SensitiveParameter]
                array $params,
            ): Connection {
                $connection = parent::connect($params);

                $connection->exec('PRAGMA foreign_keys=ON');

                return $connection;
            }
        };
    }
}
