<?php

namespace App\Http\Controllers\Creator;

use App\Enums\InputType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Question\OrderRequest;
use App\Http\Requests\Creator\Question\StoreRequest;
use App\Http\Requests\Creator\Question\DestroyRequest;
use App\Http\Requests\Creator\Question\EditRequest;
use App\Http\Requests\Creator\Question\UpdateRequest;
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
            ->with('status', __('notification.success.add', ['model' => __('Question')]));
    }

    public function edit(EditRequest $request, Question $question)
    {
        $section = $question->section;

        return Inertia::render('Creator/Question/Edit', [
            'exam' => $section->exam,
            'section' => $section,
            'config' => $section->exam->config,
            'input_type' => InputType::toSelectArray(),
            'question' => $question,
            'options' => $question->options->transform(function ($option) {
                return [
                    'id' => $option->id,
                    'key' => $option->uuid,
                    'value' => $option->value,
                    'image'=> $option->image,
                    'type' => $option->type,
                    'correct_id' => $option->correct_id,
                ];
            }),
            'correct_answer' => $question->answer,
        ]);
    }

    public function update(UpdateRequest $request, Question $question)
    {
        DB::beginTransaction();

        $question->update($request->dataQuestion());

        OptionService::updateOptions($question, $request->dataOptions());

        DB::commit();

        return redirect()->back()->with('status', __('notification.success.update', ['model' => __('Question')]));
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
            ->with('status', __('notification.success.delete', ['model' => __('Section')]));
    }
}
