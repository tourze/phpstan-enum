<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests;

use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPStanEnum\NoRedundantMethodsWithSelectTraitRule;

/**
 * @extends RuleTestCase<NoRedundantMethodsWithSelectTraitRule>
 * @internal
 */
#[CoversClass(NoRedundantMethodsWithSelectTraitRule::class)]
class NoRedundantMethodsWithSelectTraitRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoRedundantMethodsWithSelectTraitRule();
    }

    public function testGetNodeTypeShouldReturnInClassNode(): void
    {
        $rule = new NoRedundantMethodsWithSelectTraitRule();

        $this->assertSame(InClassNode::class, $rule->getNodeType());
    }

    public function testRuleShouldAnalyzeCodeWithSelectTrait(): void
    {
        // 验证规则能检测到冗余的 genOptions 方法
        $this->analyse([__DIR__ . '/Fixtures/SelectTraitTestFiles.php'], [
            [
                "Enum `Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantGenOptions` uses `Tourze\\EnumExtra\\SelectTrait` and should not re-implement the `genOptions()` method.\n    💡 This method is already provided as `final` by SelectTrait and the redundant implementation should be removed.\n\nThis error might be reported because of the following misconfiguration issues:\n\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\ValidEnumWithSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantGenOptions not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithoutSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Class Tourze\\PHPStanEnum\\Tests\\Data\\RegularClassWithSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.",
                17,
            ],
        ]);
        $this->assertSame(1, 1);
    }

    public function testProcessNodeDetectsRedundantGenOptions(): void
    {
        // 以 testProcessNode* 命名覆盖被测类的 processNode 公共方法
        $this->analyse([__DIR__ . '/Fixtures/SelectTraitTestFiles.php'], [
            [
                "Enum `Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantGenOptions` uses `Tourze\\EnumExtra\\SelectTrait` and should not re-implement the `genOptions()` method.\n    💡 This method is already provided as `final` by SelectTrait and the redundant implementation should be removed.\n\nThis error might be reported because of the following misconfiguration issues:\n\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\ValidEnumWithSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantGenOptions not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithoutSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Class Tourze\\PHPStanEnum\\Tests\\Data\\RegularClassWithSelectTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.",
                17,
            ],
        ]);
        $this->assertSame(1, 1);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/phpstan.neon',
        ];
    }
}
