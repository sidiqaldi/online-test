<?php

namespace App\Http\Controllers\Participant;

use App\Answer;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Participant\Exam\DetailsRequest;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ExamResource;
use App\Participant;
use App\Section;
use App\Services\ParticipantService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function form(Request $request)
    {
        return Inertia::render('Participant/Exam/Form');
    }

    public function details(DetailsRequest $request)
    {
        return redirect()->route('participant.exams.details.show', $request->input('code'));
    }

    public function show($code)
    {
        $exam = Exam::query()->where('code', $code)->firstOrFail();
        return Inertia::render('Participant/Exam/Details', [
            'config' => new ConfigResource($exam->config),
            'creator' => $exam->user->name,
            'exam' => new ExamResource($exam),
        ]);
    }

    public function join(Exam $exam)
    {
        return ParticipantService::join($exam);
    }

    public function section(Participant $participant, Answer $answer, Section $section)
    {
        $exam = $participant->exam;

        return Inertia::render('Participant/Exam/Section', [
            'answer' => $answer,
            'answers' => ParticipantService::getParticipantAnswers($participant),
            'config' => new ConfigResource($exam->config),
            'exam' => new ExamResource($exam),
            'participant' => $participant,
            'section' => $section,
        ]);
    }

    public function process(Participant $participant, Answer $answer)
    {
        $exam = $participant->exam;

        return Inertia::render('Participant/Exam/Process', [
            'answer' => $answer,
            'answers' => ParticipantService::getParticipantAnswers($participant),
            'config' => new ConfigResource($exam->config),
            'exam' => new ExamResource($exam),
            'options' => $answer->question->options,
            'participant' => $participant,
            'question' => $answer->question,
            'section' => $answer->section,
        ]);
    }
}
