<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuidPrimaryKey
{
    protected static function bootHasUuidPrimaryKey()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::orderedUuid();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
