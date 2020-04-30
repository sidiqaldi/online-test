<?php 

namespace App\Services\Exams;

use App\Answer;
use App\Enums\TimeMode;
use App\Exam;
use App\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BasicExam
{
    public function join(Exam $exam)
    {
        $participant = $this->getParticipantUser($exam);

        if ($participant) {

            if ($this->onGoing($participant)) {
                return redirect()->route('participant.exams.process', [
                    'participant' => $participant->uuid, 
                    'answer' => $this->firstQuestion($participant)->uuid
                ]);
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

        return redirect()->route('participant.exams.process', [
            'participant' => Participant::find($participant->id)->uuid, 
            'answer' => $this->firstQuestion($participant)->uuid
        ]);
    }

    public function getParticipantUser(Exam $exam)
    {
        return $exam->participants()->where('user_id', Auth::id())->first();
    }

    public function firstQuestion(Participant $participant)
    {
        return $participant->answers()->where('option_id', NULL)->first() ?? $participant->answers()->orderBy('id','desc')->first();
    }

    public function onGoing(Participant $participant)
    {
        if (!empty($participant->finish_at)) {
            return false;
        }

        return true;
    }
}