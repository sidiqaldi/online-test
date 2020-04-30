<?php

namespace App\Http\Controllers\Creator;

use App\Config;
use App\Enums\ExamStatus;
use App\Exam;
use App\Filters\ExamFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Exam\DestroyRequest;
use App\Http\Requests\Creator\Exam\PublishRequest;
use App\Http\Requests\Creator\Exam\UpdateRequest;
use App\Http\Requests\Creator\Exam\StoreRequest;
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
            'filters' => $request->all('name'),
            'exams' => ExamResource::collection(
                Exam::filter(new ExamFilter($request))
                    ->owner(Auth::user())
                    ->paginate($perPage)
            )
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
            ->with('status', __('notification.success.add', ['model' => __('Exam')]))
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
            ->with('status', __('notification.success.update', ['model' => __('Exam')]))
            ->with('pops', null);
    }

    public function destroy(DestroyRequest $request, Exam $exam)
    {
        $exam->delete();

        return redirect()->back()
            ->with('status', __('notification.success.destroy', ['model' => __('Exam')]))
            ->with('pops', null);
    }

    public function publish(PublishRequest $request, Exam $exam)
    {
        if (!$exam->sections->count()) {
            return redirect()->back()->withErrors(['exam' => [__('validation.no_sections')]]);
        }

        foreach ($exam->sections as $section) {
            if (!$section->questions()->count()) {
                return redirect()->back()->withErrors(['exam' => [__('validation.no_questions')]]);
            }
        }

        $exam->status_id = $exam->status_id == ExamStatus::Publish ? ExamStatus::Draft : ExamStatus::Publish;
        $exam->save();

        return redirect()->back()
            ->with('status', __('notification.success.update', ['model' => __('Exam')]))
            ->with('pops', null);
    }
}
