<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\Middleware;

use Corma\DBAL\Driver\Result;
use Corma\DBAL\Driver\Statement;
use Corma\DBAL\ParameterType;

abstract class AbstractStatementMiddleware implements Statement
{
    public function __construct(private readonly Statement $wrappedStatement)
    {
    }

    public function bindValue(int|string $param, mixed $value, ParameterType $type): void
    {
        $this->wrappedStatement->bindValue($param, $value, $type);
    }

    public function execute(): Result
    {
        return $this->wrappedStatement->execute();
    }
}
