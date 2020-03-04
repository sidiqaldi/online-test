<?php

namespace App\Http\Requests\Qestion;

use App\Enums\CorrectStatus;
use App\Enums\InputType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:15|max:150',
            'description' => 'required|min:50|max:250',
            'options' => 'required|array|min:2|max:6',
            'options.*.type' => [
                'required',
                InputType::getValues(),
            ],
            'options.*.value' => [
                'required',
                'distinct'
            ],
            'options.*.is_correct' => [
                'required',
                CorrectStatus::getValues(),
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataQuestion()
    {
        return [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'user_id' => Auth::user()->id,
            'code' => $this->input('code'),
        ];
    }

    /**
     * @return array 
     */
    public function dataOptions()
    {
        return $this->options;
    }
}
