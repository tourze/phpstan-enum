<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests;

use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPStanEnum\NoRedundantMethodsWithItemTraitRule;

/**
 * @extends RuleTestCase<NoRedundantMethodsWithItemTraitRule>
 * @internal
 */
#[CoversClass(NoRedundantMethodsWithItemTraitRule::class)]
class NoRedundantMethodsWithItemTraitRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoRedundantMethodsWithItemTraitRule();
    }

    public function testGetNodeTypeShouldReturnInClassNode(): void
    {
        $rule = new NoRedundantMethodsWithItemTraitRule();

        $this->assertSame(InClassNode::class, $rule->getNodeType());
    }

    public function testRuleShouldAnalyzeCodeWithItemTrait(): void
    {
        // 验证规则能检测到冗余的 toArray 方法
        $this->analyse([__DIR__ . '/Fixtures/ItemTraitTestFiles.php'], [
            [
                "Enum `Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantToArray` uses `Tourze\\EnumExtra\\ItemTrait` and should not re-implement the `toArray()` method.\n    💡 This method is already provided as `final` by ItemTrait and the redundant implementation should be removed.\n\nThis error might be reported because of the following misconfiguration issues:\n\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\ValidEnumWithItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantToArray not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithoutItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Class Tourze\\PHPStanEnum\\Tests\\Data\\RegularClassWithItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.",
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

    public function testProcessNodeDetectsRedundantToArray(): void
    {
        // 以 testProcessNode* 命名覆盖被测类的 processNode 公共方法
        $this->analyse([__DIR__ . '/Fixtures/ItemTraitTestFiles.php'], [
            [
                "Enum `Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantToArray` uses `Tourze\\EnumExtra\\ItemTrait` and should not re-implement the `toArray()` method.\n    💡 This method is already provided as `final` by ItemTrait and the redundant implementation should be removed.\n\nThis error might be reported because of the following misconfiguration issues:\n\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\ValidEnumWithItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithRedundantToArray not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Enum Tourze\\PHPStanEnum\\Tests\\Data\\EnumWithoutItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.\n* Class Tourze\\PHPStanEnum\\Tests\\Data\\RegularClassWithItemTrait not found in ReflectionProvider. Configure \"autoload-dev\" section in composer.json to include your tests directory.",
                17,
            ],
        ]);
        $this->assertSame(1, 1);
    }
}
