<?php

declare(strict_types=1);

namespace Corma\DBAL\SQL\Builder;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Schema\Schema;
use Corma\DBAL\Schema\Sequence;
use Corma\DBAL\Schema\Table;

use function array_merge;

final class DropSchemaObjectsSQLBuilder
{
    public function __construct(private readonly AbstractPlatform $platform)
    {
    }

    /** @return list<string> */
    public function buildSQL(Schema $schema): array
    {
        return array_merge(
            $this->buildSequenceStatements($schema->getSequences()),
            $this->buildTableStatements($schema->getTables()),
        );
    }

    /**
     * @param list<Table> $tables
     *
     * @return list<string>
     */
    private function buildTableStatements(array $tables): array
    {
        return $this->platform->getDropTablesSQL($tables);
    }

    /**
     * @param list<Sequence> $sequences
     *
     * @return list<string>
     */
    private function buildSequenceStatements(array $sequences): array
    {
        $statements = [];

        foreach ($sequences as $sequence) {
            $statements[] = $this->platform->getDropSequenceSQL($sequence->getQuotedName($this->platform));
        }

        return $statements;
    }
}
