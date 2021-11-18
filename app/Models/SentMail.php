<?php

namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentMail extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $fillable = ['subscriber_id', 'post_id'];

    public function scopePost($query, Post $post)
    {
        return $query->where('post_id', $post->id);
    }

    public function scopeSubscriber($query, Subscriber $subscriber)
    {
        return $query->where('subscriber_id', $subscriber->id);
    }
}
