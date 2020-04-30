<?php

namespace App\Services;

use App\Answer;
use App\Enums\TimeMode;
use App\Exam;
use App\Participant;
use App\Services\Exams\BasicExam;
use App\Services\Exams\TimeLimitExam;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ParticipantService
{
    static $service;

    public static function examRouter(Exam $exam)
    {
        $config = $exam->config;
        if ($config->time_mode == TimeMode::TimeLimit) {
            static::$service = new TimeLimitExam();
        } else {
            static::$service = new BasicExam();
        }
    }

    public static function join(Exam $exam)
    {
        self::examRouter($exam);

        return static::$service->join($exam);
    }
}
