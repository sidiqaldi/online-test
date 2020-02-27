<?php

namespace App\Http\Controllers\Creator;

use App\Config;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Config\UpdateRequest;

class ConfigController extends Controller
{
    public function update(UpdateRequest $request, Config $config)
    {
        $config->update($request->data());

        return redirect()->route('creator.exams.edit', Exam::find($config->exam_id)->uuid)
            ->with('status', __('notification.success.update', ['model' => __('general.Config')]))
            ->with( 'pops', 'config');
    }
}
