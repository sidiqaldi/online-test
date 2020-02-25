<?php

namespace App\Http\Controllers\Creator;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Services\ConfigService;
use Inertia\Inertia;

class ConfigController extends Controller
{
    public function update(Exam $exam)
    {
        $options = ConfigService::getConfigOptions();

        return Inertia::render('Creator/Exam/Edit', array_merge([
            'exam' => $exam,
            'config' => $exam->config,
        ], $options));
    }
}
