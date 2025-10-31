<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests\Data;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;

enum TestableEnum: string
{
    case OPTION_A = 'a';
    case OPTION_B = 'b';
}

enum AnotherTestableEnum: string
{
    case STATUS_ACTIVE = 'active';
    case STATUS_INACTIVE = 'inactive';
}

// Valid test case - should not trigger error
/**
 * @internal
 */
#[CoversClass(TestableEnum::class)]
class ValidEnumTest extends AbstractEnumTestCase
{
    // 保留空测试类，供 PHPStan 规则分析使用
}

// Invalid test case - should trigger error (line 20)
/**
 * @internal
 */
#[CoversClass(TestableEnum::class)]
class InvalidEnumTest extends TestCase
{
    // 保留空测试类，供 PHPStan 规则分析使用
}

// Another invalid test case - should trigger error (line 30)
/**
 * @internal
 */
#[CoversClass(AnotherTestableEnum::class)]
class AnotherInvalidEnumTest extends TestCase
{
    // 保留空测试类，供 PHPStan 规则分析使用
}

// Regular test case - should not trigger error (no CoversClass with enum)
/**
 * @internal
 */
#[CoversClass(TestCase::class)]
class RegularTest extends TestCase
{
    // 保留空测试类，供 PHPStan 规则分析使用
}
