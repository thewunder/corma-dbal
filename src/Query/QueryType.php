<?php

declare(strict_types=1);

namespace Doctrine\DBAL\Query;

enum QueryType
{
    case SELECT;
    case DELETE;
    case UPDATE;
    case INSERT;
}
