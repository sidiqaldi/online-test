<?php

namespace App\Http\Controllers\Creator;

use App\Exam;
use App\Http\Controllers\Controller;
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
}
