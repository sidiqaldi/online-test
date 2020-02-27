<?php

namespace App\Http\Controllers\Creator;

use App\Config;
use App\Exam;
use App\Filters\ExamFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\UpdateRequest;
use App\Http\Requests\Exam\StoreRequest;
use App\Http\Resources\ExamResource;
use App\Services\ConfigService;
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
        return Inertia::render('Creator/Exam/Create');
    }

    public function store(StoreRequest $request)
    {
        $exam = Exam::create($request->data());

        Config::create(ConfigService::defaultConfig($exam));

        return redirect()->route('creator.exams.edit', $exam->uuid)
            ->with('status', __('notification.success.add', ['model' => __('general.Exam')]))
            ->with('pops', 'config');
    }

    public function edit(Exam $exam)
    {
        $options = ConfigService::getConfigOptions();

        return Inertia::render('Creator/Exam/Edit', array_merge([
            'exam' => $exam,
            'config' => $exam->config,
        ], $options));
    }

    public function update(UpdateRequest $request, Exam $exam)
    {
        $exam->update($request->data());

        return redirect()->back()
            ->with('status', __('notification.success.update', ['model' => __('general.Exam')]))
            ->with('pops', null);
    }
}
