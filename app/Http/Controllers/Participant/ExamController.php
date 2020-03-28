<?php

namespace App\Http\Controllers\Participant;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Participant\Exam\DetailsRequest;
use App\Http\Requests\Participant\Exam\JoinRequest;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ExamResource;
use App\Participant;
use App\Services\ParticipantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $exam = Exam::where('code', $code)->firstOrFail();
        return Inertia::render('Participant/Exam/Details', [
            'exam' => new ExamResource($exam),
            'config' => new ConfigResource($exam->config),
            'creator' => $exam->user->name,
        ]);
    }

    public function join(Exam $exam)
    {
        return ParticipantService::join($exam);
    }

    public function process(Participant $participant)
    {
        dd($participant);
    }
}
