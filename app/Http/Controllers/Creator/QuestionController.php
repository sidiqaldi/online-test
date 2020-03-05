<?php

namespace App\Http\Controllers\Creator;

use App\Enums\InputType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Question;
use App\Section;
use App\Services\OptionService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Section $section)
    {
        return Inertia::render('Creator/Question/Index', [
            'exam' => $section->exam,
            'section' => $section,
            'questions' => $section->questions,
        ]);
    }

    public function create(Section $section)
    {
        return Inertia::render('Creator/Question/Create', [
            'exam' => $section->exam,
            'section' => $section,
            'config' => $section->exam->config,
            'input_type' => InputType::toSelectArray(),
        ]);
    }

    public function store(StoreRequest $request, Section $section)
    {
        DB::beginTransaction();

        $question = Question::create($request->dataQuestion($section));

        OptionService::storeOptions($question, $request->dataOptions());

        DB::commit();

        return redirect()->route('creator.questions.index', $section->uuid)
            ->with('status', __('notification.success.add', ['model' => __('general.Question')]));
    }
}
