<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\API\MySQL;

use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\Exception;
use Corma\DBAL\Exception\ConnectionException;
use Corma\DBAL\Exception\ConnectionLost;
use Corma\DBAL\Exception\DatabaseDoesNotExist;
use Corma\DBAL\Exception\DeadlockException;
use Corma\DBAL\Exception\DriverException;
use Corma\DBAL\Exception\ForeignKeyConstraintViolationException;
use Corma\DBAL\Exception\InvalidFieldNameException;
use Corma\DBAL\Exception\LockWaitTimeoutException;
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
    /**
     * @link https://dev.mysql.com/doc/mysql-errors/8.0/en/client-error-reference.html
     * @link https://dev.mysql.com/doc/mysql-errors/8.0/en/server-error-reference.html
     */
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        return match ($exception->getCode()) {
            1008 => new DatabaseDoesNotExist($exception, $query),
            1213 => new DeadlockException($exception, $query),
            1205 => new LockWaitTimeoutException($exception, $query),
            1050 => new TableExistsException($exception, $query),
            1051,
            1146 => new TableNotFoundException($exception, $query),
            1216,
            1217,
            1451,
            1452,
            1701 => new ForeignKeyConstraintViolationException($exception, $query),
            1062,
            1557,
            1569,
            1586 => new UniqueConstraintViolationException($exception, $query),
            1054,
            1166,
            1611 => new InvalidFieldNameException($exception, $query),
            1052,
            1060,
            1110 => new NonUniqueFieldNameException($exception, $query),
            1064,
            1149,
            1287,
            1341,
            1342,
            1343,
            1344,
            1382,
            1479,
            1541,
            1554,
            1626 => new SyntaxErrorException($exception, $query),
            1044,
            1045,
            1046,
            1049,
            1095,
            1142,
            1143,
            1227,
            1370,
            1429,
            2002,
            2005,
            2054 => new ConnectionException($exception, $query),
            2006 => new ConnectionLost($exception, $query),
            1048,
            1121,
            1138,
            1171,
            1252,
            1263,
            1364,
            1566 => new NotNullConstraintViolationException($exception, $query),
            default => new DriverException($exception, $query),
        };
    }
}
