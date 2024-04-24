<?php

declare(strict_types=1);

namespace PhpEnumHelperTrait\Tests\FakeEnums;

require __DIR__ . '/../../vendor/autoload.php';

use PhpEnumHelperTrait\EnumHelperTrait;

enum BackedStringEnum: string
{
    use EnumHelperTrait;

    case BACKED_STRING_ONE = 'string one';
    case BACKED_STRING_TWO = 'string two';
    case BACKED_STRING_THREE = 'string three';
    case BACKED_STRING_FOUR = 'string four';
}
