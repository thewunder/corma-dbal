<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Types;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Types\GuidType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GuidTypeTest extends TestCase
{
    private AbstractPlatform&MockObject $platform;
    private GuidType $type;

    protected function setUp(): void
    {
        $this->platform = $this->createMock(AbstractPlatform::class);
        $this->type     = new GuidType();
    }

    public function testConvertToPHPValue(): void
    {
        self::assertIsString($this->type->convertToPHPValue('foo', $this->platform));
        self::assertIsString($this->type->convertToPHPValue('', $this->platform));
    }

    public function testNullConversion(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }
}
