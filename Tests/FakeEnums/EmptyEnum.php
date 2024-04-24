<?php

declare(strict_types=1);

namespace PhpEnumHelperTrait\Tests\FakeEnums;

require __DIR__ . '/../../vendor/autoload.php';

use PhpEnumHelperTrait\EnumHelperTrait;

enum EmptyEnum
{
    use EnumHelperTrait;
}
