<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Base class for all unknown database object related errors detected in the driver.
 *
 * A database object is considered any asset that can be created in a database
 * such as schemas, tables, views, sequences, triggers,  constraints, indexes,
 * functions, stored procedures etc.
 *
 * @psalm-immutable
 */
class DatabaseObjectNotFoundException extends ServerException
{
}
