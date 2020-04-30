<?php

namespace App;

use App\Enums\CorrectStatus;
use App\Filters\Filterable;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @method static self filter($param)
 * @method static self where(int|null $id)
 * @method static self owner(\Illuminate\Contracts\Auth\Authenticatable|null $user)
 * @method static self paginate($perPage)
 * @method static create(array $data)
 * @property mixed id
 */
class Question extends Model
{
    use Filterable, HasOwner;

    protected $fillable = ['user_id', 'section_id', 'type', 'title', 'value', 'image', 'order', 'time_limit'];

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
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany('App\Option');
    }

    public function getAnswerAttribute()
    {
        foreach ($this->options()->get() as $key => $answer) {
            if ($answer->correct_id == CorrectStatus::True) {
                return (object) [
                    'key' => $key,
                    'answer' => $answer->uuid
                ];
            }
        }
    }
}
