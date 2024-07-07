<?php

declare(strict_types=1);

namespace Doctrine\StaticAnalysis\DBAL;

use Corma\DBAL\Connection;
use Corma\DBAL\DriverManager;

final class MyConnection extends Connection
{
}

function makeMeACustomConnection(): MyConnection
{
    return DriverManager::getConnection([
        'wrapperClass' => MyConnection::class,
    ]);
}
