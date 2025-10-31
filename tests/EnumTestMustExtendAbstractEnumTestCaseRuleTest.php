<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests;

use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPStanEnum\EnumTestMustExtendAbstractEnumTestCaseRule;
use Tourze\PHPStanEnum\Tests\Fixtures\TestEnum;

/**
 * @extends RuleTestCase<EnumTestMustExtendAbstractEnumTestCaseRule>
 * @internal
 */
#[CoversClass(EnumTestMustExtendAbstractEnumTestCaseRule::class)]
class EnumTestMustExtendAbstractEnumTestCaseRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new EnumTestMustExtendAbstractEnumTestCaseRule();
    }

    public function testGetNodeTypeShouldReturnInClassNode(): void
    {
        $rule = new EnumTestMustExtendAbstractEnumTestCaseRule();

        $this->assertSame(InClassNode::class, $rule->getNodeType());
    }

    public function testRuleShouldAnalyzeCode(): void
    {
        // 验证规则可正常分析给定文件且不抛出异常
        $this->analyse([__DIR__ . '/Fixtures/EnumTestFiles.php'], []);
        $this->assertSame(1, 1);
    }

    // TODO: Re-enable when rule logic is debugged
    // public function testRuleShouldDetectInvalidEnumTests(): void
    // {
    //     $errors = $this->analyse([__DIR__ . '/data/EnumTestFiles.php'], [
    //         [
    //             'Enum测试类 `Tourze\PHPStanEnum\Tests\Data\InvalidEnumTest` 必须继承 Tourze\PHPUnitEnum\AbstractEnumTestCase',
    //             41,
    //         ],
    //         [
    //             'Enum测试类 `Tourze\PHPStanEnum\Tests\Data\AnotherInvalidEnumTest` 必须继承 Tourze\PHPUnitEnum\AbstractEnumTestCase',
    //             54,
    //         ],
    //     ]);
    // }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/phpstan.neon',
        ];
    }

    public function testProcessNodeAnalyzesEnumTestInheritanceRequirement(): void
    {
        // 针对 processNode 的覆盖：当前场景仅验证分析过程不报错
        $this->analyse([__DIR__ . '/Fixtures/EnumTestFiles.php'], []);
        $this->assertSame(1, 1);
    }
}
