<?php

namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $fillable = ['website_id', 'email', 'subscription_verified_at'];

    protected $casts = [
        'subscription_verified_at' => 'datetime',
    ];

    public function confirmed()
    {
        return $this->subscription_verified_at !== null;
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
