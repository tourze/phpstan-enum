<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests\Fixtures;

/**
 * 用于测试目的的枚举
 */
enum TestEnum: string
{
    case VALUE_A = 'a';
    case VALUE_B = 'b';
}
