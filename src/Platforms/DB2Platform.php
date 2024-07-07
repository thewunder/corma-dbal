<?php

declare(strict_types=1);

namespace Corma\DBAL\Platforms;

use Corma\DBAL\Connection;
use Corma\DBAL\Platforms\Exception\NotSupported;
use Corma\DBAL\Platforms\Keywords\DB2Keywords;
use Corma\DBAL\Platforms\Keywords\KeywordList;
use Corma\DBAL\Schema\ColumnDiff;
use Corma\DBAL\Schema\DB2SchemaManager;
use Corma\DBAL\Schema\Identifier;
use Corma\DBAL\Schema\Index;
use Corma\DBAL\Schema\TableDiff;
use Corma\DBAL\SQL\Builder\DefaultSelectSQLBuilder;
use Corma\DBAL\SQL\Builder\SelectSQLBuilder;
use Corma\DBAL\TransactionIsolationLevel;
use Corma\DBAL\Types\Types;

use function array_merge;
use function count;
use function current;
use function explode;
use function implode;
use function sprintf;
use function str_contains;

/**
 * Provides the behavior, features and SQL dialect of the IBM DB2 database platform of the oldest supported version.
 */
class DB2Platform extends AbstractPlatform
{
    /**
     * {@inheritDoc}
     */
    public function getBlobTypeDeclarationSQL(array $column): string
    {
        // todo blob(n) with $column['length'];
        return 'BLOB(1M)';
    }

    protected function initializeDoctrineTypeMappings(): void
    {
        $this->doctrineTypeMapping = [
            'bigint'    => Types::BIGINT,
            'binary'    => Types::BINARY,
            'blob'      => Types::BLOB,
            'character' => Types::STRING,
            'clob'      => Types::TEXT,
            'date'      => Types::DATE_MUTABLE,
            'decimal'   => Types::DECIMAL,
            'double'    => Types::FLOAT,
            'integer'   => Types::INTEGER,
            'real'      => Types::FLOAT,
            'smallint'  => Types::SMALLINT,
            'time'      => Types::TIME_MUTABLE,
            'timestamp' => Types::DATETIME_MUTABLE,
            'varbinary' => Types::BINARY,
            'varchar'   => Types::STRING,
        ];
    }

    protected function getBinaryTypeDeclarationSQLSnippet(?int $length): string
    {
        return $this->getCharTypeDeclarationSQLSnippet($length) . ' FOR BIT DATA';
    }

    protected function getVarbinaryTypeDeclarationSQLSnippet(?int $length): string
    {
        return $this->getVarcharTypeDeclarationSQLSnippet($length) . ' FOR BIT DATA';
    }

    /**
     * {@inheritDoc}
     */
    public function getClobTypeDeclarationSQL(array $column): string
    {
        // todo clob(n) with $column['length'];
        return 'CLOB(1M)';
    }

    /**
     * {@inheritDoc}
     */
    public function getBooleanTypeDeclarationSQL(array $column): string
    {
        return 'SMALLINT';
    }

    /**
     * {@inheritDoc}
     */
    public function getIntegerTypeDeclarationSQL(array $column): string
    {
        return 'INTEGER' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritDoc}
     */
    public function getBigIntTypeDeclarationSQL(array $column): string
    {
        return 'BIGINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritDoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $column): string
    {
        return 'SMALLINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $column): string
    {
        $autoinc = '';
        if (! empty($column['autoincrement'])) {
            $autoinc = ' GENERATED BY DEFAULT AS IDENTITY';
        }

        return $autoinc;
    }

    public function getBitAndComparisonExpression(string $value1, string $value2): string
    {
        return 'BITAND(' . $value1 . ', ' . $value2 . ')';
    }

    public function getBitOrComparisonExpression(string $value1, string $value2): string
    {
        return 'BITOR(' . $value1 . ', ' . $value2 . ')';
    }

    protected function getDateArithmeticIntervalExpression(
        string $date,
        string $operator,
        string $interval,
        DateIntervalUnit $unit,
    ): string {
        switch ($unit) {
            case DateIntervalUnit::WEEK:
                $interval = $this->multiplyInterval($interval, 7);
                $unit     = DateIntervalUnit::DAY;
                break;

            case DateIntervalUnit::QUARTER:
                $interval = $this->multiplyInterval($interval, 3);
                $unit     = DateIntervalUnit::MONTH;
                break;
        }

        return $date . ' ' . $operator . ' ' . $interval . ' ' . $unit->value;
    }

    public function getDateDiffExpression(string $date1, string $date2): string
    {
        return 'DAYS(' . $date1 . ') - DAYS(' . $date2 . ')';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $column): string
    {
        if (isset($column['version']) && $column['version'] === true) {
            return 'TIMESTAMP(0) WITH DEFAULT';
        }

        return 'TIMESTAMP(0)';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTypeDeclarationSQL(array $column): string
    {
        return 'DATE';
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeTypeDeclarationSQL(array $column): string
    {
        return 'TIME';
    }

    public function getTruncateTableSQL(string $tableName, bool $cascade = false): string
    {
        $tableIdentifier = new Identifier($tableName);

        return 'TRUNCATE ' . $tableIdentifier->getQuotedName($this) . ' IMMEDIATE';
    }

    public function getSetTransactionIsolationSQL(TransactionIsolationLevel $level): string
    {
        throw NotSupported::new(__METHOD__);
    }

    /** @internal The method should be only used from within the {@see AbstractSchemaManager} class hierarchy. */
    public function getListViewsSQL(string $database): string
    {
        return 'SELECT NAME, TEXT FROM SYSIBM.SYSVIEWS';
    }

    /** @internal The method should be only used from within the {@see AbstractPlatform} class hierarchy. */
    public function supportsCommentOnStatement(): bool
    {
        return true;
    }

    public function getCurrentDateSQL(): string
    {
        return 'CURRENT DATE';
    }

    public function getCurrentTimeSQL(): string
    {
        return 'CURRENT TIME';
    }

    public function getCurrentTimestampSQL(): string
    {
        return 'CURRENT TIMESTAMP';
    }

    /** @internal The method should be only used from within the {@see AbstractPlatform} class hierarchy. */
    public function getIndexDeclarationSQL(Index $index): string
    {
        // Index declaration in statements like CREATE TABLE is not supported.
        throw NotSupported::new(__METHOD__);
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCreateTableSQL(string $name, array $columns, array $options = []): array
    {
        $indexes = [];
        if (isset($options['indexes'])) {
            $indexes = $options['indexes'];
        }

        $options['indexes'] = [];

        $sqls = parent::_getCreateTableSQL($name, $columns, $options);

        foreach ($indexes as $definition) {
            $sqls[] = $this->getCreateIndexSQL($definition, $name);
        }

        return $sqls;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlterTableSQL(TableDiff $diff): array
    {
        $sql         = [];
        $columnSql   = [];
        $commentsSQL = [];

        $tableNameSQL = $diff->getOldTable()->getQuotedName($this);

        $queryParts = [];
        foreach ($diff->getAddedColumns() as $column) {
            $columnDef = $column->toArray();
            $queryPart = 'ADD COLUMN ' . $this->getColumnDeclarationSQL($column->getQuotedName($this), $columnDef);

            // Adding non-nullable columns to a table requires a default value to be specified.
            if (
                ! empty($columnDef['notnull']) &&
                ! isset($columnDef['default']) &&
                empty($columnDef['autoincrement'])
            ) {
                $queryPart .= ' WITH DEFAULT';
            }

            $queryParts[] = $queryPart;

            $comment = $column->getComment();

            if ($comment === '') {
                continue;
            }

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $tableNameSQL,
                $column->getQuotedName($this),
                $comment,
            );
        }

        foreach ($diff->getDroppedColumns() as $column) {
            $queryParts[] =  'DROP COLUMN ' . $column->getQuotedName($this);
        }

        foreach ($diff->getModifiedColumns() as $columnDiff) {
            if ($columnDiff->hasCommentChanged()) {
                $newColumn     = $columnDiff->getNewColumn();
                $commentsSQL[] = $this->getCommentOnColumnSQL(
                    $tableNameSQL,
                    $newColumn->getQuotedName($this),
                    $newColumn->getComment(),
                );
            }

            $this->gatherAlterColumnSQL(
                $tableNameSQL,
                $columnDiff,
                $sql,
                $queryParts,
            );
        }

        foreach ($diff->getRenamedColumns() as $oldColumnName => $column) {
            $oldColumnName = new Identifier($oldColumnName);

            $queryParts[] =  'RENAME COLUMN ' . $oldColumnName->getQuotedName($this) .
                ' TO ' . $column->getQuotedName($this);
        }

        if (count($queryParts) > 0) {
            $sql[] = 'ALTER TABLE ' . $tableNameSQL . ' ' . implode(' ', $queryParts);
        }

        // Some table alteration operations require a table reorganization.
        if (count($diff->getDroppedColumns()) > 0 || count($diff->getModifiedColumns()) > 0) {
            $sql[] = "CALL SYSPROC.ADMIN_CMD ('REORG TABLE " . $tableNameSQL . "')";
        }

        $sql = array_merge(
            $this->getPreAlterTableIndexForeignKeySQL($diff),
            $sql,
            $commentsSQL,
            $this->getPostAlterTableIndexForeignKeySQL($diff),
        );

        return array_merge($sql, $columnSql);
    }

    public function getRenameTableSQL(string $oldName, string $newName): string
    {
        return sprintf('RENAME TABLE %s TO %s', $oldName, $newName);
    }

    /**
     * Gathers the table alteration SQL for a given column diff.
     *
     * @param string       $table      The table to gather the SQL for.
     * @param ColumnDiff   $columnDiff The column diff to evaluate.
     * @param list<string> $sql        The sequence of table alteration statements to fill.
     * @param list<string> $queryParts The sequence of column alteration clauses to fill.
     */
    private function gatherAlterColumnSQL(
        string $table,
        ColumnDiff $columnDiff,
        array &$sql,
        array &$queryParts,
    ): void {
        $alterColumnClauses = $this->getAlterColumnClausesSQL($columnDiff);

        if (empty($alterColumnClauses)) {
            return;
        }

        // If we have a single column alteration, we can append the clause to the main query.
        if (count($alterColumnClauses) === 1) {
            $queryParts[] = current($alterColumnClauses);

            return;
        }

        // We have multiple alterations for the same column,
        // so we need to trigger a complete ALTER TABLE statement
        // for each ALTER COLUMN clause.
        foreach ($alterColumnClauses as $alterColumnClause) {
            $sql[] = 'ALTER TABLE ' . $table . ' ' . $alterColumnClause;
        }
    }

    /**
     * Returns the ALTER COLUMN SQL clauses for altering a column described by the given column diff.
     *
     * @return string[]
     */
    private function getAlterColumnClausesSQL(ColumnDiff $columnDiff): array
    {
        $newColumn = $columnDiff->getNewColumn()->toArray();

        $alterClause = 'ALTER COLUMN ' . $columnDiff->getNewColumn()->getQuotedName($this);

        if ($newColumn['columnDefinition'] !== null) {
            return [$alterClause . ' ' . $newColumn['columnDefinition']];
        }

        $clauses = [];

        if (
            $columnDiff->hasTypeChanged() ||
            $columnDiff->hasLengthChanged() ||
            $columnDiff->hasPrecisionChanged() ||
            $columnDiff->hasScaleChanged() ||
            $columnDiff->hasFixedChanged()
        ) {
            $clauses[] = $alterClause . ' SET DATA TYPE ' . $newColumn['type']->getSQLDeclaration($newColumn, $this);
        }

        if ($columnDiff->hasNotNullChanged()) {
            $clauses[] = $newColumn['notnull'] ? $alterClause . ' SET NOT NULL' : $alterClause . ' DROP NOT NULL';
        }

        if ($columnDiff->hasDefaultChanged()) {
            if (isset($newColumn['default'])) {
                $defaultClause = $this->getDefaultValueDeclarationSQL($newColumn);

                if ($defaultClause !== '') {
                    $clauses[] = $alterClause . ' SET' . $defaultClause;
                }
            } else {
                $clauses[] = $alterClause . ' DROP DEFAULT';
            }
        }

        return $clauses;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPreAlterTableIndexForeignKeySQL(TableDiff $diff): array
    {
        $sql = [];

        $tableNameSQL = $diff->getOldTable()->getQuotedName($this);

        foreach ($diff->getDroppedIndexes() as $droppedIndex) {
            foreach ($diff->getAddedIndexes() as $addedIndex) {
                if ($droppedIndex->getColumns() !== $addedIndex->getColumns()) {
                    continue;
                }

                if ($droppedIndex->isPrimary()) {
                    $sql[] = 'ALTER TABLE ' . $tableNameSQL . ' DROP PRIMARY KEY';
                } elseif ($droppedIndex->isUnique()) {
                    $sql[] = 'ALTER TABLE ' . $tableNameSQL . ' DROP UNIQUE ' . $droppedIndex->getQuotedName($this);
                } else {
                    $sql[] = $this->getDropIndexSQL($droppedIndex->getQuotedName($this), $tableNameSQL);
                }

                $sql[] = $this->getCreateIndexSQL($addedIndex, $tableNameSQL);

                $diff->unsetAddedIndex($addedIndex);
                $diff->unsetDroppedIndex($droppedIndex);

                break;
            }
        }

        return array_merge($sql, parent::getPreAlterTableIndexForeignKeySQL($diff));
    }

    /**
     * {@inheritDoc}
     */
    protected function getRenameIndexSQL(string $oldIndexName, Index $index, string $tableName): array
    {
        if (str_contains($tableName, '.')) {
            [$schema]     = explode('.', $tableName);
            $oldIndexName = $schema . '.' . $oldIndexName;
        }

        return ['RENAME INDEX ' . $oldIndexName . ' TO ' . $index->getQuotedName($this)];
    }

    /**
     * {@inheritDoc}
     *
     * @internal The method should be only used from within the {@see AbstractPlatform} class hierarchy.
     */
    public function getDefaultValueDeclarationSQL(array $column): string
    {
        if (! empty($column['autoincrement'])) {
            return '';
        }

        if (! empty($column['version'])) {
            if ((string) $column['type'] !== 'DateTime') {
                $column['default'] = '1';
            }
        }

        return parent::getDefaultValueDeclarationSQL($column);
    }

    public function getEmptyIdentityInsertSQL(string $quotedTableName, string $quotedIdentifierColumnName): string
    {
        return 'INSERT INTO ' . $quotedTableName . ' (' . $quotedIdentifierColumnName . ') VALUES (DEFAULT)';
    }

    public function getCreateTemporaryTableSnippetSQL(): string
    {
        return 'DECLARE GLOBAL TEMPORARY TABLE';
    }

    public function getTemporaryTableName(string $tableName): string
    {
        return 'SESSION.' . $tableName;
    }

    protected function doModifyLimitQuery(string $query, ?int $limit, int $offset): string
    {
        if ($offset > 0) {
            $query .= sprintf(' OFFSET %d ROWS', $offset);
        }

        if ($limit !== null) {
            $query .= sprintf(' FETCH NEXT %d ROWS ONLY', $limit);
        }

        return $query;
    }

    public function getLocateExpression(string $string, string $substring, ?string $start = null): string
    {
        if ($start === null) {
            return sprintf('LOCATE(%s, %s)', $substring, $string);
        }

        return sprintf('LOCATE(%s, %s, %s)', $substring, $string, $start);
    }

    public function getSubstringExpression(string $string, string $start, ?string $length = null): string
    {
        if ($length === null) {
            return sprintf('SUBSTR(%s, %s)', $string, $start);
        }

        return sprintf('SUBSTR(%s, %s, %s)', $string, $start, $length);
    }

    public function getLengthExpression(string $string): string
    {
        return 'LENGTH(' . $string . ', CODEUNITS32)';
    }

    public function getCurrentDatabaseExpression(): string
    {
        return 'CURRENT_USER';
    }

    public function supportsIdentityColumns(): bool
    {
        return true;
    }

    public function createSelectSQLBuilder(): SelectSQLBuilder
    {
        return new DefaultSelectSQLBuilder($this, 'WITH RR USE AND KEEP UPDATE LOCKS', null);
    }

    public function getDummySelectSQL(string $expression = '1'): string
    {
        return sprintf('SELECT %s FROM sysibm.sysdummy1', $expression);
    }

    /**
     * {@inheritDoc}
     *
     * DB2 supports savepoints, but they work semantically different than on other vendor platforms.
     *
     * TODO: We have to investigate how to get DB2 up and running with savepoints.
     */
    public function supportsSavepoints(): bool
    {
        return false;
    }

    protected function createReservedKeywordsList(): KeywordList
    {
        return new DB2Keywords();
    }

    public function createSchemaManager(Connection $connection): DB2SchemaManager
    {
        return new DB2SchemaManager($connection, $this);
    }
}
