<?php

namespace App\Http\Controllers\Creator;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Section\DestroyRequest;
use App\Http\Requests\Section\OrderRequest;
use App\Http\Requests\Section\StoreRequest;
use App\Section;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function index(Exam $exam)
    {
        return Inertia::render('Creator/Section/Index', [
            'exam' => $exam,
            'sections' => $exam->sections,
        ]);
    }

    public function create(Exam $exam)
    {
        return Inertia::render('Creator/Section/Create', [
            'exam' => $exam,
            'config' => $exam->config,
        ]);
    }

    public function store(StoreRequest $request, Exam $exam)
    {
        Section::create($request->data($exam));

        return redirect()->route('creator.sections.index', $exam->uuid)
            ->with('success', __('notification.success.add', ['model' => __('general.Section')]));
    }

    public function order(OrderRequest $request, Section $section)
    {
        $sections = Section::whereBetween('order_id', $request->all());

        if ($request->input('from') > $request->input('to')) {
            $sections->increment('order_id');
        } else {
            $sections->decrement('order_id');
        }

        $section->order_id = $request->input('to');

        $section->save();

        return response()->json('OK');
    }

    public function destroy(DestroyRequest $request, Section $section)
    {
        $exam = $section->exam;

        $section->delete();

        return redirect()->route('creator.sections.index', $exam->uuid)
            ->with('success', __('notification.success.delete', ['model' => __('general.Section')]));
    }
}
