<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\API\SQLSrv;

use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Exception\ConnectionException;
use Corma\DBAL\Exception\DatabaseObjectNotFoundException;
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
 * @link https://docs.microsoft.com/en-us/sql/relational-databases/errors-events/database-engine-events-and-errors
 */
final class ExceptionConverter implements ExceptionConverterInterface
{
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        return match ($exception->getCode()) {
            102 => new SyntaxErrorException($exception, $query),
            207 => new InvalidFieldNameException($exception, $query),
            208 => new TableNotFoundException($exception, $query),
            209 => new NonUniqueFieldNameException($exception, $query),
            515 => new NotNullConstraintViolationException($exception, $query),
            547,
            4712 => new ForeignKeyConstraintViolationException($exception, $query),
            2601,
            2627 => new UniqueConstraintViolationException($exception, $query),
            2714 => new TableExistsException($exception, $query),
            3701,
            15151 => new DatabaseObjectNotFoundException($exception, $query),
            11001,
            18456 => new ConnectionException($exception, $query),
            default => new DriverException($exception, $query),
        };
    }
}
