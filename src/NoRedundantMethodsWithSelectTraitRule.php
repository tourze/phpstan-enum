<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Tourze\EnumExtra\SelectTrait;

/**
 * @implements Rule<InClassNode>
 */
class NoRedundantMethodsWithSelectTraitRule implements Rule
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
        $classReflection = $scope->getClassReflection();

        if (null === $classReflection || !$classReflection->isEnum()) {
            return [];
        }

        $traitNames = array_map(fn ($trait) => $trait->getName(), $classReflection->getTraits());
        if (!in_array(SelectTrait::class, $traitNames, true)) {
            return [];
        }

        $errors = [];
        // Only check methods that are truly final in SelectTrait
        $finalMethodsToCheck = ['genOptions'];

        $classLike = $node->getOriginalNode();

        foreach ($finalMethodsToCheck as $methodName) {
            $foundInEnum = false;
            foreach ($classLike->stmts as $stmt) {
                if ($stmt instanceof ClassMethod && $stmt->name->toString() === $methodName) {
                    $foundInEnum = true;
                    break;
                }
            }

            if ($foundInEnum) {
                $errors[] = RuleErrorBuilder::message(sprintf(
                    'Enum `%s` uses `%s` and should not re-implement the `%s()` method.',
                    $classReflection->getName(),
                    SelectTrait::class,
                    $methodName
                ))->identifier('enumTrait.redundantMethod')
                    ->tip('This method is already provided as `final` by SelectTrait and the redundant implementation should be removed.')
                    ->build()
                ;
            }
        }

        return $errors;
    }
}
