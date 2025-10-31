<?php

declare(strict_types=1);

namespace Tourze\PHPStanEnum\Tests\Data;

use Tourze\EnumExtra\ItemTrait;

enum ValidEnumWithItemTrait: string
{
    use ItemTrait;

    case OPTION_A = 'a';
    case OPTION_B = 'b';
}

enum EnumWithRedundantToArray: string
{
    use ItemTrait;

    case STATUS_ACTIVE = 'active';
    case STATUS_INACTIVE = 'inactive';

    // This should trigger an error - toArray is already provided by ItemTrait as final
    public function toArray(): array
    {
        return ['status' => $this->value];
    }
}

enum EnumWithoutItemTrait: string
{
    case TYPE_A = 'type_a';
    case TYPE_B = 'type_b';

    // This should NOT trigger an error - enum doesn't use ItemTrait
    public function toArray(): array
    {
        return ['type' => $this->value];
    }
}

class RegularClassWithItemTrait
{
    use ItemTrait;

    // This should NOT trigger an error - it's not an enum
    public function toArray(): array
    {
        return [];
    }
}
