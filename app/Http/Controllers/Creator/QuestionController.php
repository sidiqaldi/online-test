<?php

namespace App\Http\Controllers\Creator;

use App\Enums\InputType;
use App\Http\Controllers\Controller;
use App\Section;
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
}
