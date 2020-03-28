<?php

namespace App\Services;

use App\Answer;
use App\Enums\TimeMode;
use App\Exam;
use App\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ParticipantService
{
    public static function join(Exam $exam)
    {
        $participant = static::getParticipantUser($exam);

        if ($participant) {

            if (static::onGoing($participant)) {
                return redirect()->route('participant.exams.process', $participant->uuid);
            }

            return redirect()->back()->withErrors(['join' => [__('validation.participate')]]);
        }

        $participant = Participant::create([
            'user_id' => Auth::id(),
            'exam_id' => $exam->id,
            'random_key' => Auth::id(),
        ]);

        foreach ($exam->sections as $section) {
            foreach ($section->questions as $question) {
                Answer::create([
                    'user_id' => Auth::id(),
                    'participant_id' => $participant->id,
                    'section_id' => $section->id,
                    'question_id' => $question->id,
                ]);
            }
        }

        return redirect()->route('participant.exams.process', Participant::find($participant->id)->uuid);
    }

    public static function getParticipantUser(Exam $exam)
    {
        return $exam->participants()->where('user_id', Auth::id())->first();
    }

    public static function onGoing(Participant $participant)
    {
        if (!empty($participant->finish_at)) {
            return false;
        }

        $config = $participant->exam->config;

        $now = Carbon::now();

        if ($config->time_mode == TimeMode::TimeLimit) {
            if ($now->gt($participant->created_at->addMinutes($config->time_limit))) {
                $participant->finish_at = $now;
                $participant->save();
                return false;
            }
        }

        return true;
    }
}
