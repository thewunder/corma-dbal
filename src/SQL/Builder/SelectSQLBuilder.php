<?php

declare(strict_types=1);

namespace Corma\DBAL\SQL\Builder;

use Corma\DBAL\Exception;
use Corma\DBAL\Query\SelectQuery;

interface SelectSQLBuilder
{
    /** @throws Exception */
    public function buildSQL(SelectQuery $query): string;
}
