<?php

namespace App\Services;

use App\Enums\AnswerOrderStatus;
use App\Enums\QuestionOrderStatus;
use App\Enums\RankingStatus;
use App\Enums\ResultStatus;
use App\Enums\TimeMode;
use App\Exam;
use Illuminate\Support\Facades\Auth;

class ConfigService
{
    public static function getConfigOptions()
    {
        return [
            'question_order' => QuestionOrderStatus::toSelectArray(),
            'time_mode' => TimeMode::toSelectArray(),
            'answer_order' => AnswerOrderStatus::toSelectArray(),
            'result_status' => ResultStatus::toSelectArray(),
            'ranking_status' => RankingStatus::toSelectArray(),
        ];
    }

    public static function defaultConfig(Exam $exam)
    {
        return [
            'user_id' => Auth::user()->id,
            'exam_id' => $exam->id,
            'time_limit' => null,
            'time_mode' => TimeMode::NoLimit,
            'question_order' => QuestionOrderStatus::Sequence,
            'answer_order' => AnswerOrderStatus::Sequence,
            'result_status' => ResultStatus::Show,
            'ranking_status' => RankingStatus::Show,
        ];
    }
}
