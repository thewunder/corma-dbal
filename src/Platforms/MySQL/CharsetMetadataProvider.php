<?php

declare(strict_types=1);

namespace Corma\DBAL\Platforms\MySQL;

/** @internal */
interface CharsetMetadataProvider
{
    public function getDefaultCharsetCollation(string $charset): ?string;
}
