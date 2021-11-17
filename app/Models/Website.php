<?php

namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $fillable = ['name', 'domain', 'description', 'onboard_message', 'farewell_message'];

    protected $hidden = ['onboard_message', 'farewell_message'];

    protected $withCount = ['posts'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
