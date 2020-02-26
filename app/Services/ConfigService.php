<?php

namespace App\Services;

use App\Enums\AnswerOrderStatus;
use App\Enums\QuestionOrderStatus;
use App\Enums\RandomAnswerStatus;
use App\Enums\RandomQuestionStatus;
use App\Enums\ShowRankingStatus;
use App\Enums\ShowResultStatus;
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
            'show_result' => ShowResultStatus::toSelectArray(),
            'show_ranking' => ShowRankingStatus::toSelectArray(),
        ];
    }

    public static function defaultConfig(Exam $exam)
    {
        return [
            'user_id' =>Auth::user()->id,
            'exam_id' => $exam->id,
            'time_limit' => null,
            'time_mode' => TimeMode::NoLimit,
            'question_order' => QuestionOrderStatus::Sequence,
            'answer_order' => AnswerOrderStatus::Sequence,
            'show_result' => ShowResultStatus::True,
            'show_ranking' => ShowRankingStatus::True,
        ];
    }
}
