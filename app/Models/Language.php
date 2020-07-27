<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $fillable = ['name'];
    protected $table = 'languages';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
