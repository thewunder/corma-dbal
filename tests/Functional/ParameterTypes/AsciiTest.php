<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\ParameterTypes;

use Corma\DBAL\ParameterType;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Tests\TestUtil;

class AsciiTest extends FunctionalTestCase
{
    public function testAsciiBinding(): void
    {
        if (! TestUtil::isDriverOneOf('sqlsrv', 'pdo_sqlsrv')) {
            self::markTestSkipped('Driver does not support ascii string binding');
        }

        $statement = $this->connection->prepare('SELECT sql_variant_property(?, \'BaseType\')');

        $statement->bindValue(1, 'test', ParameterType::ASCII);
        $results = $statement->executeQuery()->fetchOne();

        self::assertEquals('varchar', $results);
    }
}
