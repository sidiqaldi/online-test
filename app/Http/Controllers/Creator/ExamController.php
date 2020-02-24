<?php

namespace App\Http\Controllers\Creator;

use App\Enums\RandomAnswerStatus;
use App\Enums\RandomQuestionStatus;
use App\Enums\ShowResultStatus;
use App\Enums\TimeMode;
use App\Filters\ExamFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\StoreRequest;
use App\Exam;
use App\Http\Resources\ExamResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return Inertia::render('Creator/Exam/Index', [
            'exams' => ExamResource::collection(Exam::filter(new ExamFilter($request))->owner(Auth::user())->paginate($perPage))
        ]);
    }

    public function create()
    {
        return Inertia::render('Creator/Exam/Create', [
            'random_question' => RandomQuestionStatus::toSelectArray(),
            'time_mode' => TimeMode::toSelectArray(),
            'random_answer' => RandomAnswerStatus::toSelectArray(),
            'show_result' => ShowResultStatus::toSelectArray(),
            'show_ranking' => ShowResultStatus::toSelectArray(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $exam = Exam::create($request->data());

        return redirect()->route('creator.exams.index')->with('status', __('notification.success.add', ['model' => __('general.Exam')]));
    }
}
