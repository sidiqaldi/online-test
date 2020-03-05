<?php

namespace App\Http\Requests\Question;

use App\Enums\CorrectStatus;
use App\Enums\InputType;
use App\Rules\CorrectValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'question_value' => [
                'required',
                'min:10',
                'max: 255',
            ],
            'question_type' => [
                'required',
                Rule::in(InputType::getValues()),
            ],
            'question_image' => [
                'sometimes',
                'nullable',
                'active_url',
            ],
            'options' => [
                'required',
                'array',
                'min:2',
                'max:6',
                new CorrectValue(),
            ],
            'options.*.type' => [
                'required',
                Rule::in(InputType::getValues()),
            ],
            'options.*.value' => [
                'required_if:options.*.type,' . InputType::Text,
                'distinct',
                'min:1',
                'max:200',
            ],
            'options.*.image' => [
                'required_if:options.*.type,' . InputType::ImageUrl,
                'distinct',
                'active_url',
            ],
            'options.*.is_correct' => [
                'required',
                Rule::in(CorrectStatus::getValues()),
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
