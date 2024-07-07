<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\API\OCI;

use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Exception\ConnectionException;
use Corma\DBAL\Exception\DatabaseDoesNotExist;
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

/** @internal */
final class ExceptionConverter implements ExceptionConverterInterface
{
    /** @link http://www.dba-oracle.com/t_error_code_list.htm */
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        return match ($exception->getCode()) {
            1,
            2299,
            38911 => new UniqueConstraintViolationException($exception, $query),
            904 => new InvalidFieldNameException($exception, $query),
            918,
            960 => new NonUniqueFieldNameException($exception, $query),
            923 => new SyntaxErrorException($exception, $query),
            942 => new TableNotFoundException($exception, $query),
            955 => new TableExistsException($exception, $query),
            1017,
            12545 => new ConnectionException($exception, $query),
            1400 => new NotNullConstraintViolationException($exception, $query),
            1918 => new DatabaseDoesNotExist($exception, $query),
            2289,
            2443,
            4080 => new DatabaseObjectNotFoundException($exception, $query),
            2266,
            2291,
            2292 => new ForeignKeyConstraintViolationException($exception, $query),
            default => new DriverException($exception, $query),
        };
    }
}
