<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Types;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Types\DecimalType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DecimalTest extends TestCase
{
    private AbstractPlatform&MockObject $platform;
    private DecimalType $type;

    protected function setUp(): void
    {
        $this->platform = $this->createMock(AbstractPlatform::class);
        $this->type     = new DecimalType();
    }

    public function testDecimalConvertsToPHPValue(): void
    {
        self::assertIsString($this->type->convertToPHPValue('5.5', $this->platform));
    }

    public function testDecimalNullConvertsToPHPValue(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }
}
