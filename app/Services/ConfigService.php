<?php

namespace App\Services;

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
            'random_question' => RandomQuestionStatus::toSelectArray(),
            'time_mode' => TimeMode::toSelectArray(),
            'random_answer' => RandomAnswerStatus::toSelectArray(),
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
            'random_questioner' => RandomQuestionStatus::False,
            'random_answer' => RandomAnswerStatus::False,
            'show_result' => ShowResultStatus::True,
            'show_ranking' => ShowRankingStatus::True,
        ];
    }
}
