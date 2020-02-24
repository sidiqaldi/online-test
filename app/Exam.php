<?php

namespace App;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @method static self filter($param)
 * @method static self where(int|null $id)
 * @method static self owner(\Illuminate\Contracts\Auth\Authenticatable|null $user)
 * @method static self paginate($perPage)
 * @method static create(array $data)
 */
class Exam extends Model
{
    use Filterable;

    protected $fillable = ['user_id', 'name', 'description'];

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
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     * @noinspection PhpUnused
     */
    public function scopeOwner(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
