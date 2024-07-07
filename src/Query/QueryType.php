<?php

declare(strict_types=1);

namespace Corma\DBAL\Query;

enum QueryType
{
    case SELECT;
    case DELETE;
    case UPDATE;
    case INSERT;
}
