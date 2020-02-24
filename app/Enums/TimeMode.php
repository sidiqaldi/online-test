<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NoLimit()
 * @method static static TimeLimit()
 * @method static static PerQuestion()
 */
final class TimeMode extends Enum
{
    const NoLimit = 1;
    const TimeLimit = 2;
    const PerQuestion = 3;
}
