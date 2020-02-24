<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Inactive()
 * @method static static Active()
 */
final class ExamStatus extends Enum
{
    const Inactive = 1;
    const Active = 2;
}
