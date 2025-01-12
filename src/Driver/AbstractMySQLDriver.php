<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\MySQL\ExceptionConverter;
use Corma\DBAL\Platforms\AbstractMySQLPlatform;
use Corma\DBAL\Platforms\Exception\InvalidPlatformVersion;
use Corma\DBAL\Platforms\MariaDB1052Platform;
use Corma\DBAL\Platforms\MariaDB1060Platform;
use Corma\DBAL\Platforms\MariaDBPlatform;
use Corma\DBAL\Platforms\MySQL80Platform;
use Corma\DBAL\Platforms\MySQLPlatform;
use Corma\DBAL\ServerVersionProvider;

use function preg_match;
use function stripos;
use function version_compare;

/**
 * Abstract base implementation of the {@see Driver} interface for MySQL based drivers.
 */
abstract class AbstractMySQLDriver implements Driver
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidPlatformVersion
     */
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): AbstractMySQLPlatform
    {
        $version = $versionProvider->getServerVersion();
        if (stripos($version, 'mariadb') !== false) {
            $mariaDbVersion = $this->getMariaDbMysqlVersionNumber($version);
            if (version_compare($mariaDbVersion, '10.6.0', '>=')) {
                return new MariaDB1060Platform();
            }

            if (version_compare($mariaDbVersion, '10.5.2', '>=')) {
                return new MariaDB1052Platform();
            }

            return new MariaDBPlatform();
        }

        if (version_compare($version, '8.0.0', '>=')) {
            return new MySQL80Platform();
        }

        return new MySQLPlatform();
    }

    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }

    /**
     * Detect MariaDB server version, including hack for some mariadb distributions
     * that starts with the prefix '5.5.5-'
     *
     * @param string $versionString Version string as returned by mariadb server, i.e. '5.5.5-Mariadb-10.0.8-xenial'
     *
     * @throws InvalidPlatformVersion
     */
    private function getMariaDbMysqlVersionNumber(string $versionString): string
    {
        if (
            preg_match(
                '/^(?:5\.5\.5-)?(mariadb-)?(?P<major>\d+)\.(?P<minor>\d+)\.(?P<patch>\d+)/i',
                $versionString,
                $versionParts,
            ) === 0
        ) {
            throw InvalidPlatformVersion::new(
                $versionString,
                '^(?:5\.5\.5-)?(mariadb-)?<major_version>.<minor_version>.<patch_version>',
            );
        }

        return $versionParts['major'] . '.' . $versionParts['minor'] . '.' . $versionParts['patch'];
    }
}
