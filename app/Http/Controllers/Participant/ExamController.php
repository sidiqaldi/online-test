<?php

namespace App\Http\Controllers\Participant;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Participant\Exam\DetailsRequest;
use App\Http\Resources\ExamResource;
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
        $exam = Exam::where('code', $code)->firstOrFail();
        return Inertia::render('Participant/Exam/Details', [
            'exam' => new ExamResource($exam),
            'creator' => $exam->user->name,
        ]);
    }

    public function join()
    {
        // return Inertia::render('Participant/Exam/Join');
    }
}
