<?php

namespace App\Traits;

use App\User;
use Illuminate\Database\Eloquent\Builder;

trait HasOwner
{
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
