<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Config extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'time_limit',
        'random_questioner',
        'random_answer',
        'show_result',
        'show_ranking'
    ];

    /**
     * Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
     * @return BelongsTo
     */
    public function config()
    {
        return $this->belongsTo('App\Exam');
    }
}
