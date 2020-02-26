<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static False()
 * @method static static True()
 */
final class ShowResultStatus extends Enum implements LocalizedEnum
{
    const False = 1;
    const True = 2;
}
