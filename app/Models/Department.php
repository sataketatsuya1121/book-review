<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\UserDetail;

class Department extends Model
{
    protected $fillable = ['name'];
    protected $table = 'departments';

    public function userDetails(): HasMany
    {
        return $this->hasMany(UserDetail::class);
    }
}
