<?php

declare(strict_types=1);

namespace Corma\DBAL\Portability;

use Corma\DBAL\Driver\Middleware\AbstractStatementMiddleware;
use Corma\DBAL\Driver\Result as ResultInterface;
use Corma\DBAL\Driver\Statement as DriverStatement;

/**
 * Portability wrapper for a Statement.
 */
final class Statement extends AbstractStatementMiddleware
{
    /**
     * Wraps <tt>Statement</tt> and applies portability measures.
     */
    public function __construct(DriverStatement $stmt, private readonly Converter $converter)
    {
        parent::__construct($stmt);
    }

    public function execute(): ResultInterface
    {
        return new Result(
            parent::execute(),
            $this->converter,
        );
    }
}
