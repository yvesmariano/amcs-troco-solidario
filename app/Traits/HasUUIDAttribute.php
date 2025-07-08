<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUUIDAttribute
{
    protected static function boot()
    {
        parent::boot();

        /**
         * Listen for the creating event on the user model.
         */
        self::creating(fn ($model) => $model->setUuid());
    }

    /**
     * Sets the 'id' to a UUID using Str::uuid() on the instance being created
     */
    public function setUuid()
    {
        $this->attributes['uuid'] = Str::uuid();
    }
}
