<?php

use App\Enums\QuestionOrderStatus;
use App\Enums\TimeMode;

return [

    TimeMode::class => [
        TimeMode::NoLimit => 'Tanpa Batas',
        TimeMode::TimeLimit => 'Batas Waktu',
        TimeMode::PerQuestion => 'Per Pertanyaan',
    ],

    QuestionOrderStatus::class => [
        QuestionOrderStatus::Sequence => 'Urut',
        QuestionOrderStatus::Random => 'Acak',
    ],

];