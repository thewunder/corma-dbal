<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\API\PostgreSQL;

use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Exception\ConnectionException;
use Corma\DBAL\Exception\DatabaseDoesNotExist;
use Corma\DBAL\Exception\DeadlockException;
use Corma\DBAL\Exception\DriverException;
use Corma\DBAL\Exception\ForeignKeyConstraintViolationException;
use Corma\DBAL\Exception\InvalidFieldNameException;
use Corma\DBAL\Exception\NonUniqueFieldNameException;
use Corma\DBAL\Exception\NotNullConstraintViolationException;
use Corma\DBAL\Exception\SchemaDoesNotExist;
use Corma\DBAL\Exception\SyntaxErrorException;
use Corma\DBAL\Exception\TableExistsException;
use Corma\DBAL\Exception\TableNotFoundException;
use Corma\DBAL\Exception\UniqueConstraintViolationException;
use Corma\DBAL\Query;

use function str_contains;

/** @internal */
final class ExceptionConverter implements ExceptionConverterInterface
{
    /** @link http://www.postgresql.org/docs/9.4/static/errcodes-appendix.html */
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        switch ($exception->getSQLState()) {
            case '40001':
            case '40P01':
                return new DeadlockException($exception, $query);

            case '0A000':
                // Foreign key constraint violations during a TRUNCATE operation
                // are considered "feature not supported" in PostgreSQL.
                if (str_contains($exception->getMessage(), 'truncate')) {
                    return new ForeignKeyConstraintViolationException($exception, $query);
                }

                break;

            case '23502':
                return new NotNullConstraintViolationException($exception, $query);

            case '23503':
                return new ForeignKeyConstraintViolationException($exception, $query);

            case '23505':
                return new UniqueConstraintViolationException($exception, $query);

            case '3D000':
                return new DatabaseDoesNotExist($exception, $query);

            case '3F000':
                return new SchemaDoesNotExist($exception, $query);

            case '42601':
                return new SyntaxErrorException($exception, $query);

            case '42702':
                return new NonUniqueFieldNameException($exception, $query);

            case '42703':
                return new InvalidFieldNameException($exception, $query);

            case '42P01':
                return new TableNotFoundException($exception, $query);

            case '42P07':
                return new TableExistsException($exception, $query);

            case '08006':
                return new ConnectionException($exception, $query);
        }

        return new DriverException($exception, $query);
    }
}
