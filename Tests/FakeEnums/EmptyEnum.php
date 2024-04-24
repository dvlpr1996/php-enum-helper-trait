<?php

declare(strict_types=1);

namespace dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums;

require __DIR__ . '/../../vendor/autoload.php';

use dvlpr1996\PhpEnumHelperTrait\EnumHelperTrait;

enum EmptyEnum
{
    use EnumHelperTrait;
}
