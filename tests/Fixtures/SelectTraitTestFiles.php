<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests\Data;

use Tourze\EnumExtra\SelectTrait;

enum ValidEnumWithSelectTrait: string
{
    use SelectTrait;

    case OPTION_A = 'a';
    case OPTION_B = 'b';
}

enum EnumWithRedundantGenOptions: string
{
    use SelectTrait;

    case STATUS_ACTIVE = 'active';
    case STATUS_INACTIVE = 'inactive';

    // This should trigger an error - genOptions is already provided by SelectTrait as final
    public function genOptions(): array
    {
        return ['active' => 'Active Status', 'inactive' => 'Inactive Status'];
    }
}

enum EnumWithoutSelectTrait: string
{
    case TYPE_A = 'type_a';
    case TYPE_B = 'type_b';

    // This should NOT trigger an error - enum doesn't use SelectTrait
    public function genOptions(): array
    {
        return ['type_a' => 'Type A', 'type_b' => 'Type B'];
    }
}

class RegularClassWithSelectTrait
{
    use SelectTrait;

    // This should NOT trigger an error - it's not an enum
    public function genOptions(): array
    {
        return [];
    }
}
