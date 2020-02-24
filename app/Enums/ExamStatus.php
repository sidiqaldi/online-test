<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Draft()
 * @method static static Publish()
 */
final class ExamStatus extends Enum
{
    const Draft = 1;
    const Publish = 2;
}
