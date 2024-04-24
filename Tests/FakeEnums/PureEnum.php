<?php

declare(strict_types=1);

namespace dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums;

require __DIR__ . '/../../vendor/autoload.php';

use dvlpr1996\PhpEnumHelperTrait\EnumHelperTrait;

enum PureEnum
{
    use EnumHelperTrait;

    case PURE_ENUM_ONE;
    case PURE_ENUM_TWO;
    case PURE_ENUM_THREE;
    case PURE_ENUM_FOUR;
}
