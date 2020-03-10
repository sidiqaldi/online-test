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
            ->with('status', __('notification.success.add', ['model' => __('general.Section')]));
    }

    public function order(OrderRequest $request, Section $section)
    {
        if ($request->input('from') > $request->input('to')) {
            Section::whereBetween('order', [ $request->input('to'), $request->input('from')])->increment('order');
        } else {
            Section::whereBetween('order', [$request->input('from'), $request->input('to')])->decrement('order');
        }

        $section->order = $request->input('to');

        $section->save();

        return redirect()->back();
    }

    public function destroy(DestroyRequest $request, Section $section)
    {
        Section::where('order', '>', $section->order)->decrement('order');

        $section->delete();

        return redirect()->back()
            ->with('status', __('notification.success.delete', ['model' => __('general.Section')]));
    }
}
