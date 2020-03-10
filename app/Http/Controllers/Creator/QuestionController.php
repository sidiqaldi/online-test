<?php

namespace App\Http\Controllers\Creator;

use App\Enums\InputType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\OrderRequest;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Requests\Question\DestroyRequest;
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
            'questions' => function () use ($section) {
                return $section->questions;
            },
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

    public function order(OrderRequest $request, Question $question)
    {
        if ($request->input('from') > $request->input('to')) {
            Question::whereBetween('order', [$request->input('to'), $request->input('from')])->increment('order');
        } else {
            Question::whereBetween('order', [$request->input('from'), $request->input('to')])->decrement('order');
        }

        $question->order = $request->input('to');

        $question->save();

        return redirect()->back();
    }

    public function destroy(DestroyRequest $request, Question $question)
    {
        Question::where('order', '>', $question->order)->decrement('order');

        $question->delete();

        return redirect()->back()
            ->with('status', __('notification.success.delete', ['model' => __('general.Section')]));
    }
}
