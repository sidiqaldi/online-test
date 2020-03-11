<?php
namespace App\Services;

use App\Enums\InputType;
use App\Option;
use App\Question;
use Illuminate\Support\Facades\Auth;

class OptionService
{
    public static function storeOptions(Question $question, $options) {
        foreach ($options as $key => $option) {
            $data = [
                'user_id' => Auth::id(),
                'question_id' => $question->id,
                'type' => $option['type'],
                'value' => $option['type'] == InputType::Text ? $option['value'] : $option['image'],
                'correct_id' => $option['correct_id'],
                'order' => $key+1
            ];
            Option::create($data);
        }
    }

    public static function updateOptions($options) {
        foreach ($options as $key => $option) {
            $data = [
                'type' => $option['type'],
                'value' => $option['type'] == InputType::Text ? $option['value'] : $option['image'],
                'correct_id' => $option['correct_id'],
                'order' => $key+1
            ];
            Option::updateOrcreate(['id' => $option['id']], $data);
        }
    }
}
