<?php

namespace App\Http\Controllers\Creator;

use App\Filters\ExamFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Test\StoreRequest;
use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return Inertia::render('Creator/Exam/Index', [
            'exams' => Exam::filter(new ExamFilter($request))->owner(Auth::user())->paginate($perPage)
        ]);
    }

    public function create()
    {
        return Inertia::render('Creator/Exam/Create');
    }

    public function store(StoreRequest $request)
    {
        $exam = Exam::create($request->data());

        return redirect()->route('creator.exams.index')->with('status', __('notification.success.add', ['model' => __('general.Exam')]));
    }
}
