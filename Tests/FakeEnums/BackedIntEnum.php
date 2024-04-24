<?php

declare(strict_types=1);

namespace dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums;

require __DIR__ . '/../../vendor/autoload.php';

use dvlpr1996\PhpEnumHelperTrait\EnumHelperTrait;

enum BackedIntEnum: int
{
    use EnumHelperTrait;

    case BACKED_INT_ONE = 1;
    case BACKED_INT_TWO = 2;
    case BACKED_INT_THREE = 3;
    case BACKED_INT_FOUR = 4;
}
