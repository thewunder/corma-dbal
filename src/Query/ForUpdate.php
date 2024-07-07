<?php

declare(strict_types=1);

namespace Corma\DBAL\Query;

use Corma\DBAL\Query\ForUpdate\ConflictResolutionMode;

/** @internal */
final class ForUpdate
{
    public function __construct(
        private readonly ConflictResolutionMode $conflictResolutionMode,
    ) {
    }

    public function getConflictResolutionMode(): ConflictResolutionMode
    {
        return $this->conflictResolutionMode;
    }
}
