<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\API\IBMDB2;

use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Exception\ConnectionException;
use Corma\DBAL\Exception\DriverException;
use Corma\DBAL\Exception\ForeignKeyConstraintViolationException;
use Corma\DBAL\Exception\InvalidFieldNameException;
use Corma\DBAL\Exception\NonUniqueFieldNameException;
use Corma\DBAL\Exception\NotNullConstraintViolationException;
use Corma\DBAL\Exception\SyntaxErrorException;
use Corma\DBAL\Exception\TableExistsException;
use Corma\DBAL\Exception\TableNotFoundException;
use Corma\DBAL\Exception\UniqueConstraintViolationException;
use Corma\DBAL\Query;

/**
 * @internal
 *
 * @link https://www.ibm.com/docs/en/db2/11.5?topic=messages-sql
 */
final class ExceptionConverter implements ExceptionConverterInterface
{
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        return match ($exception->getCode()) {
            -104 => new SyntaxErrorException($exception, $query),
            -203 => new NonUniqueFieldNameException($exception, $query),
            -204 => new TableNotFoundException($exception, $query),
            -206 => new InvalidFieldNameException($exception, $query),
            -407 => new NotNullConstraintViolationException($exception, $query),
            -530,
            -531,
            -532,
            -20356 => new ForeignKeyConstraintViolationException($exception, $query),
            -601 => new TableExistsException($exception, $query),
            -803 => new UniqueConstraintViolationException($exception, $query),
            -1336,
            -30082 => new ConnectionException($exception, $query),
            default => new DriverException($exception, $query),
        };
    }
}
