<?php

namespace App\Http\Requests\Test;

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
        ];
    }

    /**
     * @return array
     */
    public function data()
    {
        return [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'user_id' => Auth::user()->id,
        ];
    }
}
