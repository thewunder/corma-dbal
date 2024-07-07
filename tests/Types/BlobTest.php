<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Types;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Types\BlobType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BlobTest extends TestCase
{
    protected AbstractPlatform&MockObject $platform;
    protected BlobType $type;

    protected function setUp(): void
    {
        $this->platform = $this->createMock(AbstractPlatform::class);
        $this->type     = new BlobType();
    }

    public function testBlobNullConvertsToPHPValue(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }
}
