<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @property mixed question
 * @property mixed section_id
 * @property mixed section
 * @property mixed uuid
 * @method static withSectionOrder()
 */
class Answer extends Model
{
    protected $fillable = ['user_id', 'participant_id', 'section_id', 'question_id'];

    /**
     * Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    /**
     * @param $query
     */
    public function scopeWithSectionOrder($query)
    {
        $query->addSelect(['section_order' => Section::query()->select('order')
            ->whereColumn('section_id', 'sections.id')
            ->take(1)
        ]);
    }
}
