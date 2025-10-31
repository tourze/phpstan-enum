<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;

/**
 * @implements Rule<InClassNode>
 */
class EnumTestMustExtendAbstractEnumTestCaseRule implements Rule
{
    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @return list<IdentifierRuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$this->isEnumTest($scope)) {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if (null === $classReflection) {
            return [];
        }

        $parentClass = $classReflection->getParentClass();
        if (null === $parentClass || AbstractEnumTestCase::class !== $parentClass->getName()) {
            $testClassName = $classReflection->getName();

            return [
                RuleErrorBuilder::message(sprintf(
                    'Enum测试类 `%s` 必须继承 ' . AbstractEnumTestCase::class,
                    $testClassName
                ))->identifier('enumTest.mustExtendAbstractEnumTestCase')
                    ->tip('所有Enum类的测试用例都必须继承 AbstractEnumTestCase 以确保测试的一致性和完整性。')
                    ->build(),
            ];
        }

        return [];
    }

    private function isEnumTest(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        if (null === $classReflection || !str_ends_with($classReflection->getName(), 'Test')) {
            return false;
        }

        $attributes = $classReflection->getNativeReflection()->getAttributes(CoversClass::class);
        if (0 === count($attributes)) {
            return false;
        }

        $coveredClassName = $attributes[0]->newInstance();
        /** @var CoversClass $coveredClassName */

        return enum_exists($coveredClassName->className());
    }
}
