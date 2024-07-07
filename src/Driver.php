<?php

declare(strict_types=1);

namespace Corma\DBAL;

use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\Connection as DriverConnection;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Platforms\AbstractPlatform;
use SensitiveParameter;

/**
 * Driver interface.
 * Interface that all DBAL drivers must implement.
 *
 * @psalm-import-type Params from DriverManager
 */
interface Driver
{
    /**
     * Attempts to create a connection with the database.
     *
     * @param array<string, mixed> $params All connection parameters.
     * @psalm-param Params $params All connection parameters.
     *
     * @return DriverConnection The database connection.
     *
     * @throws Exception
     */
    public function connect(
        #[SensitiveParameter]
        array $params,
    ): DriverConnection;

    /**
     * Gets the DatabasePlatform instance that provides all the metadata about
     * the platform this driver connects to.
     *
     * @return AbstractPlatform The database platform.
     */
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): AbstractPlatform;

    /**
     * Gets the ExceptionConverter that can be used to convert driver-level exceptions into DBAL exceptions.
     */
    public function getExceptionConverter(): ExceptionConverter;
}
