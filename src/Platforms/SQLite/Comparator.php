<?php

declare(strict_types=1);

namespace Corma\DBAL\Platforms\SQLite;

use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Schema\Comparator as BaseComparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Schema\TableDiff;

use function strcasecmp;

/**
 * Compares schemas in the context of SQLite platform.
 *
 * BINARY is the default column collation and should be ignored if specified explicitly.
 */
class Comparator extends BaseComparator
{
    /** @internal The comparator can be only instantiated by a schema manager. */
    public function __construct(SQLitePlatform $platform)
    {
        parent::__construct($platform);
    }

    public function compareTables(Table $oldTable, Table $newTable): TableDiff
    {
        return parent::compareTables(
            $this->normalizeColumns($oldTable),
            $this->normalizeColumns($newTable),
        );
    }

    private function normalizeColumns(Table $table): Table
    {
        $table = clone $table;

        foreach ($table->getColumns() as $column) {
            $options = $column->getPlatformOptions();

            if (! isset($options['collation']) || strcasecmp((string) $options['collation'], 'binary') !== 0) {
                continue;
            }

            unset($options['collation']);
            $column->setPlatformOptions($options);
        }

        return $table;
    }
}
